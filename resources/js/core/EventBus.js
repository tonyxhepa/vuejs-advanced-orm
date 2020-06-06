export default class EventBus {
    constructor() {
        this.bus = new Vue;
    }

    fire(events, ...data) {
        this.wrapper(
            events,
            () => this.bus.$emit(events, ...data),
            index => this.bus.$emit(events[index], ...data)
        );
    }
    listen(events, callback) {
        this.wrapper(
            events,
            () => this.bus.$on(events, callback),
            index => this.bus.$on(events[index], callback)
        );
    }
    wrapper(events, ifNotArray, atherwaise) {
        if (!Array.isArray(events)){
            ifNotArray();
            return;
        }
        for (const index in events) {
            atherwaise(index);
        }
    }
}
