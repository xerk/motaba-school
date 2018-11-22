<template>
    <div>
        <div v-for="(option, key) in options" :key="key">
            <div class="form-group col-md-10">
            <input required="" :type="inputType" class="form-control" v-model="option.tel" :placeholder="name" value="">
        </div>
        <div class="form-group col-md-2">
            <div class="btn btn-danger delete-row" @click="removeOption(key)">
                <i class="voyager-trash"></i>
            </div>
        </div>
        </div>
        <div class="form-group col-md-4">
            <a @click="addOption" class="btn btn-success">+ Add New {{ name }}</a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Array,
            required: true,
        },
        name: {
            type: String,
            required: true
        },
        inputType: {
            type: String,
            required: true
        }
    },
    methods: {
        removeOption(key) {
            this.options.splice(key, 1);
        },
        addOption() {
            this.options.push({
                tel: ''
            });
        },
    }
}
</script>
