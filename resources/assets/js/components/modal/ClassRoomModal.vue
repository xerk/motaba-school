<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <button type="button" class="close" @click="$emit('close')" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            <div :class="{'form-group col-md-12': true, 'has-error': errors.has('class') }">                            
                                <label for="name">{{ trans('configs.Class Education') }}</label>
                                <select required class="form-control select2" v-validate="'required'" v-model="itemClassRoom.class_edu_id.$model">
                                    <option value="">{{ trans('configs.Choose Class')}}</option>
                                    <option v-for="(item,key) in classEdu" :key="key" :value="item.id">{{ item.name }}</option>
                                </select>
                                <span v-show="errors.has('class')" class="help-block" style="color:#f96868">{{ errors.first('class') }}</span>
                            </div>
                            <div :class="{'form-group col-md-12': true, 'has-error': errors.has('name') }">
                                <label for="name">{{ trans('configs.Name') }}</label>
                                <input required v-model="itemClassRoom.$model.name" type="text" v-validate="'required'" class="form-control" name="name">
                                <span v-show="errors.has('name')" class="help-block" style="color:#f96868">{{ errors.first('name') }}</span>
                            </div>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-default" @click="$emit('close')">
                                {{ trans('table.Cancel')}}
                            </button>
                            <!-- <slot tag="button" name="button" class="btn btn-danger delete-confirm" @click="submit">
                                Yest, Save it!
                            </slot> -->
                            <button slot="button" @click="submit" class="btn btn-success">{{ trans('table.Yes, Save it!')}}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['itemClassRoom'],
    data() {
        return {
            get: {
                apiURL: 'system-configs'
            },
            post: {
                apiURL: 'system-configs-update-class-room',
            },
            classEdu: '',
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.classEdu = response.data.classEdu
                })
        },
        submit() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.$store.dispatch('submitForm', {
                            post: this.post,
                            model: this.itemClassRoom.$model,
                        })
                        .then(response => {
                            this.$toast.success({
                                title: response.data
                            })
                            this.$emit('close')
                            this.$emit('update', this.itemClassRoom)
                        })
                }
            })
        },
    },
}
</script>


<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
        margin-bottom: 22px;
        border: 1px solid transparent;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
    }

    .close {
        color: #fff;
        opacity: 0.6;
    }

    .close:hover {
        color: #fff;
        opacity: 1;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header {
        padding: 20px;
        background-color: #22A7F0;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #fff;
        font-size: 18px;
        margin: 0;
        line-height: 1.42857143;
    }

    .modal-default-button {
        float: right;
    }

    .modal-footer button {
        margin: auto;
    }

    .close {
        margin: 15px 15px 0px
    }
    /*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

</style>
