<template>
    <div>
        <div class="row">
            <div class="col align-self-start">
                <v-select
                    :items="questionType"
                    label="Question Type"
                    solo

                ></v-select>
            </div>
            <div class="col align-self-center"></div>
            <div class="col align-self-end">
                <v-text-field min="0" v-model="point" type="number" label="Points" append-outer-icon="add" @click:append-outer="increment" prepend-icon="remove" @click:prepend="decrement"></v-text-field>
            </div>
        </div>

        <ckeditor v-model.trim="$v.question.$model"></ckeditor>
        <div class="text-danger" v-if="!$v.question.required">Question field is required</div>

        <v-divider class="mx-2" inset vertical></v-divider>

        <div v-for="(option, index) in options">
            <div class="input-group">
                <div class="my-2"><hr></div>
                <input type="text" placeholder="Option" class="form-control">
                <div class="input-group-prepend ml-2 mt-2">
                    <input type="checkbox" name="" id=""><small>Correct</small>
                </div>
                <svg v-show="options.length > 1" @click="removeField(index, options)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="ml-2 cursor-pointer"><path fill="none" d="M0 0h24v24H0z" />
                    <path fill="#EC4899" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"/>
                </svg>
            </div>
        </div>
        <div class="text-left mt-3">
            <button class="btn btn-success" @click="submit()">Add Question</button>
        </div>
        <div class="text-right mt-3">
            <button class="btn btn-outline-secondary px-4" @click="cancel()">cancel</button>
            <button class="btn btn-primary px-4" click="save()">Save</button>
        </div>
    </div>
</template>

<script>
    import { required, minLength } from 'vuelidate/lib/validators'
    export default {
        data : ()=>({
            question:null,
            questionType: ['Single Choice', 'Multiple Choice'],
            options: [{option:""}],
            point: 0,
            
        }),
        validations: {
            question: {
                required
            }
        },
        methods: {
            increment () {
                this.point = parseInt(this.point,10) + 1
            },
            decrement () {
                this.point = (this.point > 0) ? parseInt(this.point,10) - 1 : this.point
            },
            submit(){
                if( this.options.length <= 3 ){
                    this.options.push({option:""});
                }
            },
            removeField(index, fieldType){
                fieldType.splice(index, 1);
            },
            save(){
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                }
            },
            cancel(){
                this.$router.push('/admin/qizzview');
            }
        }
    }
</script>