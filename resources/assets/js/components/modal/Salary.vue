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
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('additional') }">
                                <label for="additional">{{ trans('salary.Additional') }}</label>
                                <input required v-model="model.additional"  type="number" v-validate="'numeric'" class="form-control" name="additional">
                                <span v-show="errors.has('additional')" class="help-block" style="color:#f96868">{{ errors.first('additional') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('bonus') }">
                                <label for="bonus">{{ trans('salary.Bonus') }}</label>
                                <input required v-model="model.bonus" type="number" v-validate="'numeric'" class="form-control" name="bonus">
                                <span v-show="errors.has('bonus')" class="help-block" style="color:#f96868">{{ errors.first('bonus') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('incentive') }">
                                <label for="incentive">{{ trans('salary.Incentive') }}</label>
                                <input required v-model="model.incentive" type="number" v-validate="'numeric'" class="form-control" name="incentive">
                                <span v-show="errors.has('incentive')" class="help-block" style="color:#f96868">{{ errors.first('incentive') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('reward') }">
                                <label for="reward">{{ trans('salary.Reward') }}</label>
                                <input required v-model="model.reward" type="number" v-validate="'numeric'" class="form-control" name="reward">
                                <span v-show="errors.has('reward')" class="help-block" style="color:#f96868">{{ errors.first('reward') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('discount') }">
                                <label for="discount">{{ trans('salary.Discount') }}</label>
                                <input required v-model="model.discount" type="number" v-validate="'numeric'" class="form-control" name="discount">
                                <span v-show="errors.has('discount')" class="help-block" style="color:#f96868">{{ errors.first('discount') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('allowance') }">
                                <label for="allowance">{{ trans('salary.Allowance') }}</label>
                                <input required v-model="model.allowance" type="number" v-validate="'numeric'" class="form-control" name="allowance">
                                <span v-show="errors.has('allowance')" class="help-block" style="color:#f96868">{{ errors.first('allowance') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('loan') }">
                                <label for="loan">{{ trans('salary.Loan') }}</label>
                                <input required v-model="model.loan" type="number" v-validate="'numeric'" class="form-control" name="loan">
                                <span v-show="errors.has('loan')" class="help-block" style="color:#f96868">{{ errors.first('loan') }}</span>
                            </div>
                            <div :class="{'form-group col-md-6': true, 'has-error': errors.has('penalty') }">
                                <label for="penalty">{{ trans('salary.Penalty') }}</label>
                                <input required v-model="model.penalty" type="number" v-validate="'numeric'" class="form-control" name="penalty">
                                <span v-show="errors.has('penalty')" class="help-block" style="color:#f96868">{{ errors.first('penalty') }}</span>
                            </div>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-default" @click="$emit('close')">
                                {{ trans('table.Cancel') }}
                            </button>
                            <!-- <slot tag="button" name="button" class="btn btn-danger delete-confirm" @click="submit">
                                Yest, Save it!
                            </slot> -->
                            <button slot="button" @click="submit" class="btn btn-success">{{ trans('table.Yes, Save it!') }}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['list'],
    data() {
        return {
            get: {
                apiURL: 'salary-emp'
            },
            post: {
                apiURL: 'salary-update',
            },
            model: {
                additional: '',
                bonus: '',
                incentive: '',
                reward: '',
                allowance: '',
                discount: '',
                loan: '',
                penalty: '',
            }
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            this.$store.dispatch('retriveAttendtion', {
                    get: this.get,
                    id: this.list.id,
                })
                .then(response => {
                    this.model = response.data.attend
                })
        },
        submit() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.$store.dispatch('submitForm', {
                            post: this.post,
                            model: this.model,
                        })
                        .then(response => {
                            this.$toast.success({
                                title: response.data
                            })
                            this.fetch()
                            this.$emit('close')
                            this.$emit('getAttend')
                        })
                }
            })
        }
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
