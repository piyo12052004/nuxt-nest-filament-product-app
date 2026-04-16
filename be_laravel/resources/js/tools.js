document.addEventListener('alpine:init', () => {
    Alpine.store('modal', {
        active: null,
        data: {},

        open(name, data = null) {
            this.active = name
            this.data = data
        },

        close() {
            this.active = null
            this.data = null
        }
    })
})
