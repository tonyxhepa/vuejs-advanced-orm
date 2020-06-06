<template>
    <div id="top-dialog" :class="wrapperClass">
        <div class="alert alert-danger" :class="visibleClass('alert')" v-html="message" @click="clear"></div>
        <div class="alert alert-warning" :class="visibleClass('warning')" v-html="message" @click="clear"></div>
    </div>
</template>

<script>
    export default {
        name: "TopDialog",
        props: {
            sessionDialog: {
                type: Object,
                default: () => {}
            }
        },
        data() {
            return {
                id: null,
                time: null,
                message: '',
                timeout: null
            }
        },
        computed: {
          isVizible() {
              return this.message !== '';
          }    ,
            wrapperClass() {
              return {
                  'overlay': this.isVizible && this.typeIs('confirm')
              }
            }
        },
        created() {
            EventBus.listen('clear-top-dialog', this.clear);
            EventBus.listen('top-alert', this.alertEvent);
            EventBus.listen('top-warning', this.warningEvent);
            EventBus.listen('top-confirm', this.confirmEvent);
        },
        mounted() {
            if (Object.keys(this.sessionDialog).length) {
                setTimeout(() => {
                    EventBus.fire(this.sessionDialog.type, {
                        id: 'session-' + this.sessionDialog.type,
                        message: this.sessionDialog.message
                    });
                }, 500);
            }
        },
        methods: {
            typeIs(type) {
                return this.type === type;
            },
            visibleClass(type) {
                return {
                    'active': this.isVizible && this.typeIs(type)
                }
            },
            clear(data = null) {
                this.clearCountDown();
                this.type = null;
                this.message = '';

                EventBus.fire(this.id, + '-cleared', data || {});
            },
            clearCountDown(){
               if (this.timeout === null) {
                   return;
               }
               clearTimeout(this.timeout);
               this.timeout = null;
            },
            alert(data, type) {
                this.clear();
                this.id = data.id;
                this.type = type;
                this.message = data.message;
                this.countDown();
            },
            alertEvent(data) {
               this.alert(data, 'alert');
            },
            warningEvent(data) {
                this.alert(data, 'warning');
            },
            confirmEvent(data) {

            },
            countDown() {
                this.timeout = setTimeout(() => {
                    this.clear();
                }, 7000);
            }
        }
    }
</script>

<style scoped>

</style>
