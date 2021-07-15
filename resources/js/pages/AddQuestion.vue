<template>
    <v-layout>
        <v-form ref="form"  v-model="valid" lazy-validation>
            <v-flex md12>
                <v-toolbar color="dark" dark>
                    <v-toolbar-title>Add Question</v-toolbar-title>
                </v-toolbar>
                <v-card>
                    <v-container fluid grid-list-lg>
                        <v-layout row wrap>
                            <v-flex xs6>
                                <v-combobox 
                                    v-model="addQuestion.type" 
                                    :items="items" 
                                    label="Choose Question Type" 
                                    :rules="[v => !!v || 'Question type is required']"
                                    solo
                                    >
                                    <template slot="item" slot-scope="data">
                                        <v-icon
                                            class="mr-2"
                                            v-if="data.item == 'Paragraph'"
                                            >segment</v-icon
                                        >
                                        <span v-if="data.item == 'Paragraph'">{{
                                            data.item
                                        }}</span>
    
                                        <v-icon
                                            class="mr-2"
                                            v-if="data.item == 'Multiple Choice'"
                                            >radio_button_checked</v-icon
                                        >
                                        <span
                                            v-if="data.item == 'Multiple Choice'"
                                            >{{ data.item }}</span
                                        >
    
                                        <v-icon
                                            class="mr-2"
                                            v-if="data.item == 'Check Box'"
                                            >check_box</v-icon
                                        >
                                        <span v-if="data.item == 'Check Box'">{{
                                            data.item
                                        }}</span>
                                    </template>
                                </v-combobox>
                            </v-flex>
    
                            <v-flex xs4 offset-xs2>
                                <v-text-field
                                    v-model="addQuestion.points" 
                                    min="0"
                                    type="number"
                                    label="Points"
                                    :rules="[v => !!v || 'Point is required']"
                                ></v-text-field>
                            </v-flex>
    
                            <v-flex xs12>
                                <v-textarea
                                    v-model="addQuestion.title"
                                    name="input-7-1"
                                    filled
                                    label="Write your question here ..."
                                    rows="1"
                                    value=""
                                    :rules="[v => !!v || 'Question is required']"
                                ></v-textarea>
                            </v-flex>
                            
                        </v-layout>

                        <v-layout row wrap>
                            <v-flex xs1 class="mt-0" v-if="addQuestion.type == 'Check Box' "> 
                                <v-checkbox
                                    v-model="addQuestion.answer[0].answer_title"
                                    label=""
                                    color="secondary"
                                    value="red"
                                    hide-details
                                    class="mb-5"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="addQuestion.answer[1].answer_title"
                                    label=""
                                    color="secondary"
                                    value="red"
                                    hide-details
                                    class="mb-5"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="addQuestion.answer[2].answer_title"
                                    label=""
                                    color="secondary"
                                    value="red"
                                    hide-details
                                    class="mb-5"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="addQuestion.answer[3].answer_title"
                                    label=""
                                    color="secondary"
                                    value="red"
                                    hide-details
                                    class=""
                                ></v-checkbox>
                            </v-flex>
                            <v-flex xs1 v-if="addQuestion.type == 'Multiple Choice' ">
                                <v-radio-group>
                                    <v-radio
                                        label=""
                                        color="secondary"
                                        value="option1"
                                        class="mb-5"
                                    ></v-radio>
                                <v-radio
                                    label=""
                                    color="secondary"
                                    value="option2"
                                    class="mb-5"
                                ></v-radio>
                                <v-radio
                                    label=""
                                    color="secondary"
                                    value="option3"
                                    class="mb-5"
                                ></v-radio>
                                <v-radio
                                    label=""
                                    color="secondary"
                                    value="option4"
                                    class="mt-0"
                                ></v-radio>
                                </v-radio-group>
                            </v-flex>
                            <v-flex xs11 class="mt-2" v-if="addQuestion.type !== 'Paragraph' ">
                                <v-text-field
                                    v-model="addQuestion.answer[0].answer_title"
                                    label="Option 1"
                                    :rules="[v => !!v || 'Option is required']"
                                ></v-text-field>
                                <v-text-field
                                    v-model="addQuestion.answer[1].answer_title"
                                    label="Option 2"
                                    :rules="[v => !!v || 'Option is required']"
                                ></v-text-field>
                                <v-text-field
                                    v-model="addQuestion.answer[2].answer_title"    
                                    label="Option 3"
                                    :rules="[v => !!v || 'Option is required']"
                                ></v-text-field>
                                <v-text-field
                                    v-model="addQuestion.answer[3].answer_title"
                                    label="Option 4"
                                    :rules="[v => !!v || 'Option is required']"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>

                        <v-divider class="mx-0"></v-divider>
    
                        <v-btn color="success" rounded @click="save()">Save</v-btn>
                    </v-container>
                </v-card>
            </v-flex>
        </v-form>
    </v-layout>
</template>

<script>
export default {
    data: () => ({
        valid: false,
        items: ["Paragraph", "Multiple Choice", "Check Box"],
        hover: "",
        radioGroup: "",
        options:[{Option:''}],
        disabled:false,
        addQuestion: {
            page: 1,
            quiz_id: null,
            title: "",
            points: "",
            type: "Multiple Choice",
            answer: [
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                },
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                },
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                },
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                }
            ]
        },
        radios:null
    }),
    mounted() {
        this.addQuestion.quiz_id = this.$route.params.quiz_id;
    },
    methods: {
        add() {
            if (this.options.length <= 3) {
                this.options.push({ option: "" });
                let obj = {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                };
                this.addQuestion.answer.push(obj);
            }else{
                this.disabled = true;
            }
        },
        unselect($event){
            console.log($event);
        },
        save(){
            console.log(this.addQuestion); return;
            this.$refs.form.validate()
            axios.post("/api/questions/", this.addQuestion).then(response => {
                console.log(response);
                response.status == 201 ? this.$swal(
                            "Inserted",
                            "Question has been inserted",
                            "success"
                        )
                    : this.errorMsg(response.data.message);
                    this.cancel();
            }).catch(error => {
                console.log(error)
                    // switch (error.response.status) {
                    //     case 400:
                    //         this.errorMsg(response.data.message);
                    //         break;
                    //     default:
                    //         break;
                    // }
                });
        }
    },
};
</script>

<style scoped>
.container.grid-list-xl .layout .flex {
    padding: 5px;
}
</style>
