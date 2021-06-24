<template>
    <div>
        <v-form ref="form" v-model="valid" lazy-validation>
            <div class="row">
                <div class="col align-self-start">
                   <v-select
                        item-text="t1"
                        item-value="t2"
                        v-model="defaultSelected"
                        :items="questionType"
                        :rules="[v => !!v || 'Question type is required']"
                        return-object
                        key = "componentKey"
                        v-on:change="changeType()"
                        solo
                    >
                    </v-select>
                </div>
                <div class="col align-self-center"></div>
                <div class="col align-self-end">
                    <!-- <v-text-field v-model="addQuestion.points" min="0" :rules="[v => !!v || 'Point is required']" type="number" label="Points"  @click:append-outer="increment" prepend-icon="remove" @click:prepend="decrement"></v-text-field> -->
                    <v-text-field v-model="addQuestion.points" min="0" :rules="[v => !!v || 'Point is required']" type="number" label="Points" ></v-text-field>

                </div>
            </div>
            
            <ckeditor v-model="addQuestion.title"></ckeditor>
            <div v-if="showError" class="v-text-field__details my-2">
                <div class="v-messages theme--light error--text">
                    <div class="v-messages__wrapper">
                        <div class="v-messages__message">Question field is required</div>
                    </div>
                </div>
            </div>

            <v-divider class="mx-2" inset vertical></v-divider>

            <div v-for="(option, index) in options">
                <div class="input-group">
                    <div class="my-2"><hr></div>

                    <!-- <input type="text" placeholder="Option" class="form-control"> -->
                    <v-text-field
                        label="Option"
                        v-model="addQuestion.options[index]"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-text-field>

                    <div class="input-group-prepend ml-2 mt-2">
                        <input type="checkbox" v-model="addQuestion.is_correct[index]"  @change="checkCorrect($event,index)" :value="index" class="mt-3 mr-1" name="" id=""><small class="mt-3">Correct</small>
                    </div>

                    <span class="mt-3">
                        <svg v-show="options.length > 1" @click="removeField(index, options)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="ml-2 cursor-pointer"><path fill="none" d="M0 0h24v24H0z" />
                            <path fill="#ed1140" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="text-left mt-3">
                    <v-btn
                        :disabled="!valid"
                        color="success"
                        class="mr-4"
                        @click="submit"
                    >
                    Add Question
                    </v-btn>
                </div>
                <div class="text-right mt-3">
                    <v-btn
                        :disabled="!valid"
                        color="white"
                        class=""
                        @click="cancel()"
                    >
                    Cancel
                    </v-btn>

                    <v-btn
                        color="warning"
                        @click="resetValidation"
                    >
                    Reset Validation
                    </v-btn>
                    <span class="" v-if="edit">
                        <v-btn
                            :disabled="!valid"
                            color="primary"
                            class=""
                            @click="update()"
                        >
                            Update
                        </v-btn>
                    </span>
                    <span class="" v-else>
                        <v-btn
                            :disabled="!valid"
                            color="primary"
                            class=""
                            @click="save()"
                        >
                            Save
                        </v-btn>
                    </span>
                    
                </div>
            </div>

        </v-form>

    </div>
</template>

<script>
    import VueSweetalert2 from 'vue-sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';
    export default{
        data: ()=>({
            edit:false,
            defaultSelected: {
                t1: "Multiple Choice",
                t2: "multiple_choice"
            },
            questionType: [
                {
                    t1: "Single Choice",
                    t2: "single_choice"
                },
                {
                    t1: "Multiple Choice",
                    t2: "multiple_choice"
                }
            ],
            
            point:0,
            valid: true,
            options: [{option:""}],
            showError:false,
            addQuestion:{
                ansId:[],
                type: 'multiple_choice',
                points:'',
                title:'',
                options:[],
                page:1,
                quiz_id:0,
                is_correct:[false]         
            },
        }),

        computed: {
            
        },
        
        mounted(){
            //this.addQuestion.page = this.$route.params.page;
            this.addQuestion.quiz_id = this.$route.params.quiz_id;
        },
        methods: {
            init(){
                axios.get(`/api/questions/${this.$route.params.id}?param=question_id`).then(response => {
                    console.log(response.data);
                    if(response.status == 200 && response.data.title){
                        this.edit = true;
                        this.addQuestion.points = response.data.points;
                        this.addQuestion.title = response.data.title;
                        if(response.data.answer.length > -1){
                            response.data.answer.forEach(this.editAnswer);
                        }
                    }
                }).catch(error=>{
                    this.edit = false;
                });
            },
            editAnswer(item, index){
                this.options = index+1;
                this.addQuestion.options[index] = item.answer_title;
                this.addQuestion.is_correct[index] = item.is_correct;
                this.addQuestion.ansId[index] = item.id;
                console.log('Edit this thsi', item);
            },
            checkCorrect(e, index){
                if (event.target.checked) {
                    this.addQuestion.is_correct[index] = true;
                    
                }else{
                    this.addQuestion.is_correct[index] = false;
                }
            },
            changeType(){
                if( this.type == 'Single Choice' ){
                    return this.addQuestion.type = 'single_choice'
                }
                if( this.type == 'Multiple Choice' ){
                    return this.addQuestion.type = 'multiple_choice'
                }
            },
            increment() {

                this.point = parseInt(this.point,10) + 1
            },
            decrement() {
                this.point = (this.point > 0) ? parseInt(this.point,10) - 1 : this.point
            },
            submit(){
                if( this.options.length <= 3 ){
                    this.options.push({option:""});
                    this.addQuestion.is_correct.push(false);
                }
            },
            removeField(index, fieldType){
                fieldType.splice(index, 1);
                this.addQuestion.is_correct.pop();
            },
            save(){
                this.$refs.form.validate()
               // if(this.$refs.form.validate())
                if(this.addQuestion.title == ""){
                    this.showError = true;
                }else{
                    this.showError = false;   
                    
                    /**
                     *  Questions
                     */
                    axios.post('/api/questions/',this.addQuestion).then(
                        response=> {
                            response.status == 201 ? this.successMsg() : this.errorMsg(response.data.message),
                            this.$refs.form.reset(),
                            this.addQuestion.title = '',
                            this.addQuestion.options = [{}] ,
                            this.options = [{option:"aaaa",is_correct:true}],
                            this.cancel()

                    }).catch(error => {
                            switch (error.response.status) {
                                case 400:
                                     this.errorMsg(response.data.message)
                                    break;
                                default:
                                    break;
                            }
                        });
                }
            },  
            resetValidation(){
                this.showError = false;
                this.$refs.form.resetValidation()
            },
            cancel(){
                this.$router.push(`/admin/qizzview/${this.$route.params.quiz_id}`);
            },
            update(){
                axios.put(`/api/questions/${this.$route.params.id}`,this.addQuestion).then(
                        response=> {
                            response.status == 201 ? this.successMsg() : this.errorMsg(response.data.message),
                           // this.$refs.form.reset(),
                            this.addQuestion.title = '',
                            this.addQuestion.options = [{}] ,
                            this.options = [{option:"aaaa", is_correct:true} ]
                            //this.cancel()
                    }).catch(error => {
                            switch (error.response.status) {
                                case 400:
                                     this.errorMsg(response.data.message)
                                    break;
                                default:
                                    break;
                            }
                        });
            },
            successMsg() {
                this.$swal(
                    'Good job!',
                    'Question has been added',
                    'success'
                );
            },
            errorMsg(msg) {
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg
                });
            }
        },
        created(){
            this.init();
        }
    }
</script>