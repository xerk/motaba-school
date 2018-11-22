<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <form @submit.prevent="validateBeforSubmit" action="">
                <div>
                    <div class="col-md-8">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('school-name') }">
                                    <label for="school-name">School Name</label>
                                    <input required type="text" v-validate="'required|min:3'" class="form-control" name="school-name" v-model="schoolConfigs.school_name" placeholder="School Name">
                                    <span v-show="errors.has('school-name')" class="help-block" style="color:#f96868">{{ errors.first('school-name') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('education-system') }">
                                    <label for="edu-system">Educational System</label>
                                    <select class="form-control" v-validate="'required'" id="education-system" name="education-system" v-model="schoolConfigs.edu_system_id">
                                        <option value="null">None</option>
                                        <option v-for="(eduSystem, key) in eduSystems" :key="key" :value="eduSystem.id">{{ eduSystem.name }}</option>
                                    </select>
                                    <span v-show="errors.has('education-system')" class="help-block" style="color:#f96868">{{ errors.first('education-system') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('website') }">
                                    <label for="website">Website</label>
                                    <input required type="text" class="form-control" v-validate="'url:require_protocol'" name="website" v-model="schoolConfigs.website" placeholder="Website">
                                    <span v-show="errors.has('website')" class="help-block" style="color:#f96868">{{ errors.first('website') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('government') }">
                                    <label for="government">Government</label>
                                    <select class="form-control" id="government" v-validate="'required'" name="government" v-model="schoolConfigs.government_id">
                                        <option value="null">None</option>
                                        <option v-for="(government, key) in governments" :key="key" :value="government.id">{{ government.name }}</option>
                                        <span v-show="errors.has('government')" class="help-block" style="color:#f96868">{{ errors.first('government') }}</span>
                                    </select>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('edu-manag') }">
                                    <label for="edu-manag">Educational Administration</label>
                                    <select class="form-control" id="edu-manag" v-validate="'required'" name="edu-manag" v-model="schoolConfigs.edu_manag_id">
                                        <option value="null">None</option>
                                        <option v-for="(eduManag, key) in eduManagFilter" :key="key" :value="eduManag.id">{{ eduManag.name }}</option>
                                    </select>
                                    <span v-show="errors.has('edu-manag')" class="help-block" style="color:#f96868">{{ errors.first('edu-manag') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('school-manager') }">
                                    <label for="school-manager">School Manager</label>
                                    <input required type="text" class="form-control" name="school-manager" v-validate="'required'" placeholder="School Manager" v-model="schoolConfigs.school_manager">
                                    <span v-show="errors.has('school-manager')" class="help-block" style="color:#f96868">{{ errors.first('school-manager') }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="follow-manager">Follow Manger</label>
                                    <input type="text" class="form-control" name="follow-manager" placeholder="Follow Manger" v-model="schoolConfigs.follow_manager">
                                </div>
                                <div :class="{'form-group col-md-8': true, 'has-error': errors.has('address') }">
                                    <label for="address">Address</label>
                                    <input required type="text" class="form-control" v-validate="'required'" name="address" placeholder="Address" v-model="schoolConfigs.address">
                                    <span v-show="errors.has('address')" class="help-block" style="color:#f96868">{{ errors.first('address') }}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="license-number">License Number</label>
                                    <input type="text" class="form-control" name="license-number" placeholder="License Number" v-model="schoolConfigs.license_number">
                                </div>
                                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('footer') }">
                                    <label for="footer">Footer</label>
                                    <textarea class="form-control" name="footer" v-validate="'min:10:|max:500'" placeholder="Type your footer" v-model="schoolConfigs.footer"></textarea>
                                    <span v-show="errors.has('footer')" class="help-block" style="color:#f96868">{{ errors.first('footer') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <croppa :width="350" v-model="images.logo" :height="350" placeholder="Logo an School" :placeholder-font-size="20">
                                </croppa>
                                <hr>
                                <croppa :width="350" v-model="images.cover" :height="150" placeholder="Cover an School" :placeholder-font-size="20">
                                </croppa>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div>
                    <div class="col-md-4">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <multi-telephone :options="telephones" :inputType="'text'" :name="'Telephone'"></multi-telephone>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <multi-mobile :options="mobiles" :inputType="'text'" :name="'Mobile'"></multi-mobile>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <multi-fax :options="faxes" :inputType="'text'" :name="'Fax'"></multi-fax>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <multi-social :options="socialMedia" :selectOptions="socialMediaName" :name="'SocialMedia'"></multi-social>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <multi-email :options="emails" :inputType="'email'" :name="'Email'"></multi-email>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
    import MultiTelephone from './multiInput/MultiTelephone'
    import MultiMobile from './multiInput/MultiMobile'
    import MultiFax from './multiInput/MultiFax'
    import MultiEmail from './multiInput/MultiEmail'
    import MultiSocial from './multiInput/MultiSocial'


    export default {
        components: {
            MultiTelephone,
            MultiMobile,
            MultiFax,
            MultiEmail,
            MultiSocial
        },
        props: {
            link: '',
        },
        data() {
            return {
                get: {
                    apiURL: 'school-configs',
                    params: {},
                    request: {},
                },
                post: {
                    apiURL: 'school-configs/add',
                },
                telephones: [
                    {
                        option: ''
                    }
                ],
                mobiles: [],
                faxes: [],
                socialMedia: [],
                schoolConfigs: [],
                emails: [],
                eduSystems: [],
                governments: [],
                eduManags: [],
                socialMediaName: [],
                images: {
                    logo: {},
                    cover: {},
                }
            }
        },
        mounted() {
            this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.schoolConfigs = response.data.data
                    this.eduSystems = response.data.eduSystems
                    this.governments = response.data.governments
                    this.eduManags = response.data.eduManags
                    this.socialMediaName = response.data.socialMedia
                    this.telephones = response.data.telephones
                    this.mobiles = response.data.mobiles
                    this.faxes = response.data.faxes
                    this.emails = response.data.emails
                    this.socialMedia = response.data.socialSchool
                })
            this.telephones.tel = this.telephones.option
        },
        computed: {
            eduManagFilter() {
                if (this.schoolConfigs.government_id == null) {
                    this.schoolConfigs.edu_manag_id = null
                } else {
                    return this.eduManags.filter(item => {
                        return item.government_id == this.schoolConfigs.government_id
                    })
                }
            }
        },
        methods: {
            validateBeforSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.submit()
                    }
                })
            },
            submit() {
                let logo = this.images.logo.generateDataUrl()
                let cover = this.images.cover.generateDataUrl()
                this.$store.dispatch('submitForm', {
                        model: this.schoolConfigs,
                        telephones: this.telephones,
                        mobiles: this.mobiles,
                        faxes: this.faxes,
                        emails: this.emails,
                        socialMedia: this.socialMedia,
                        post: this.post,
                        logo: logo,
                        cover: cover,
                        id: this.schoolConfigs.id,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: 'Successfully',
                            message: response.data
                        })
                    })
                    .catch(error => {
                        // this.serverError = Object.values(error.response.data.errors)
                    })
            }
        }
    }

</script>
