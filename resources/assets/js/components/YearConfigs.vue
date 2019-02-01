<template>
    <div class="container">
        <horizontal-stepper :steps="demoSteps" @completed-step="completeStep" @active-step="isStepActive" @stepper-finished="alert">
        </horizontal-stepper>
    </div>
</template>

<script>
    import HorizontalStepper from 'vue-stepper';

    // This components will have the content for each stepper step.
    import StepOne from './yearStepper/StepOne';
    import StepTwo from './yearStepper/StepTwo';

    export default {
        components: {
            HorizontalStepper
        },
        data() {
            return {
                demoSteps: [{
                        icon: 'school',
                        name: 'first',
                        title: 'Year',
                        subtitle: 'Add academic year',
                        component: StepOne,
                        completed: false

                    },
                    {
                        icon: 'book',
                        name: 'second',
                        title: 'Semester',
                        subtitle: 'Add Semester',
                        component: StepTwo,
                        completed: false
                    },
                    
                ],
            }
        },
        methods: {
            // Executed when @completed-step event is triggered
            completeStep(payload) {
                this.demoSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        step.completed = true;
                        this.$toast.info({
                            title: 'Info',
                            message: 'Next step is ready to config'
                        })
                    }
                })
            },
            // Executed when @active-step event is triggered
            isStepActive(payload) {
                this.demoSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        if (step.completed === true) {
                            step.completed = false;
                        }
                    }
                })
            },
            // Executed when @stepper-finished event is triggered
            alert(payload) {
                alert('Thank your for complete data.')
            }
        }
    }

</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0
}
.list-item {
  display: inline-block;
  margin-right: 3px;
}
.list-enter-active, .list-leave-active {
  transition: all 0.5s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
</style>
