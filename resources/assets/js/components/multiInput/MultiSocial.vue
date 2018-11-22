<template>
    <div>
        <div v-for="(option, key) in options" :key="key">
            <div class="form-group col-md-5">
                <select class="form-control select2" v-model="option.social_id" :id="name">
                    <option value="">Choose {{ name }}</option>
                    <option v-for="(item,key) in selectOptions" :key="key" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <input required="" type="text" class="form-control" v-model="option.link" placeholder="Setting Link ex: http://www.example.com/" value="">
            </div>
            <div class="form-group col-md-2">
                <div @click="removeOption(key)" class="btn btn-danger delete-row">
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
            selectOptions: {
                type: Array,
                required: true
            },
            options: {
                type: Array,
                required: true
            },
            name: {
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
                    social_id: '',
                    link: '',
                });
            },
        }
    }

</script>
