<template>
    <transition name="modal">
        <div class="modal-mask" dir="rtl">
            <div class="modal-wrapper">
                <div slot="master" class="modal-container">
                    <button type="button" class="close pull-left" @click="$emit('close')" data-dismiss="modal" aria-label="Close"><span>×</span></button>
                    <div class="modal-header">
                        <h3>
                            <i class="voyager-edit" style="vertical-align: sub;"></i> {{ trans('configs.Edit Timetable')}}
                        </h3>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            <div :class="{'form-group col-md-12': true, 'has-error': errors.has('subject') }">
                                <select style="height: 40px;" id="m_subject" v-validate="'required'" v-model="selectRow.subject_id" class="form-control" name="subject">
                                    <option value="" selected="selected">{{ trans('fab.Choose Subject')}}</option>
                                    <option v-for="(subject, key) in subjects" :key="key" :value="subject.id">{{ subject.name }}</option>
                                </select>
                                <span v-show="errors.has('subject')" class="help-block" style="color:#f96868">{{ errors.first('subject') }}</span>
                            </div>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-default pull-left" @click="$emit('close')">
                                {{trans('table.Cancel')}}
                            </button>
                            <button slot="button" @click="onConfirm" class="btn btn-success delete-confirm pull-left">{{ trans('table.Yes, Save it!')}}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ["selectRow", "subjects"],
    methods: {
		onConfirm() {
			this.$emit("confirm", this.selectRow);
        },
		onCancel() {
			this.$emit("cancel");
		},
	}
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
        background-color: #064377;
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
        text-align: left;
    }

    .close {
        margin: 15px 15px 0px;
        color: #fff;
        opacity: 0.5;
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
