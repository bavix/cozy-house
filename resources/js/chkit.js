// require('./bootstrap');
import axios from 'axios'
import {v4} from 'uuid'
import {debounce} from 'lodash'

const StoreAPI = function (prefix, storage) {
    return {
        get(key) {
            let data = storage.getItem(prefix + key)
            if (data !== null) {
                data = JSON.parse(data)
            }
            return data
        },
        set(key, data) {
            storage.setItem(prefix + key, JSON.stringify(data))
        },
        remove(key) {
            storage.removeItem(prefix + key)
        },
        count(key) {
            return (this.get(key) || []).length
        },
        bulk(key, batchSize) {
            const data = this.get(key) || []
            const result = data.splice(0, batchSize)
            this.set(key, data)
            return result
        },
        setProp(key, value) {
            this.set('prop_' + key, value)
        },
        getProp(key) {
            return this.get('prop_' + key)
        },
        push(key, ...data) {
            const val = this.get(key) || []
            val.push(...data)
            this.set(key, val)
        },
        identify() {
            let val = this.get('identify')
            if (val === null) {
                this.set('identify', val = v4())
            }
            return val;
        },
    }
}

export default function (baseUrl, token) {
    const storeApi = new StoreAPI('___ch_', localStorage);

    this.setApiUrl = (apiUrl) => {
        baseUrl = apiUrl
    }

    this.setToken = (value) => {
        token = value
    }

    this.setProp = (key, value) => {
        storeApi.setProp(key, value)
    }

    this.push = (category, name, label, payload) => {
        const event = {
            request_url: location.href,
            request_id: v4(),
            category,
            name,
            label,
            payload: payload || {},
            identify: storeApi.identify(),
            datetime: (new Date()).toISOString()
        };

        const clientId = storeApi.getProp('client_id');
        if (clientId) {
            event.client_id = clientId.toString();
        }

        storeApi.push('events', event)
        this.dispatch()
    }

    this.dispatch = debounce((sendBeacon) => {
        if (!baseUrl || !token) return;
        const batchSize = 100
        const maxItem = storeApi.count('events')
        for (let i = 0; i < maxItem; i += batchSize) {
            const prepared = storeApi.bulk('events', batchSize);
            if (!prepared.length) {
                break;
            }

            if (sendBeacon) {
                const blob = new Blob([JSON.stringify({events: prepared, token})], {
                    type: 'application/json',
                })

                const restore = !navigator.sendBeacon(baseUrl + '/api/sendBeacon', blob)
                if (restore) {
                    storeApi.push('events', ...prepared)
                }
            } else {
                axios.post(baseUrl + '/api/events', prepared, {
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${token}`,
                    },
                    withCredentials: true
                }).catch(() => {
                    storeApi.push('events', ...prepared)
                })
            }
        }
    })

    return this
};
