import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('modal', {
    active: null,
    data: {},

    open(name, data = {}) {
        this.active = name
        this.data = data ?? {}
    },

    close() {
        this.active = null
        this.data = {}
    }
})
// import './tools';

Alpine.start();
