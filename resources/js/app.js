import chkit from './chkit'

const ch = new chkit()
ch.setApiUrl(location.origin)
ch.setToken('1|y6pQWyFiCPSRFto15uiEddcU2ezDpVPVAu3UWhYLJfRQd2FU2NOhM4hckXxs5O4BSHz5rnzu1gP5EDZ6')
window.addEventListener('DOMContentLoaded', ch.dispatch);
window.onunload = (event) => {
    if (navigator.sendBeacon) {
        ch.dispatch(true);
    }
}

window.ch = ch
