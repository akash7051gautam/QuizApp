<template>
    <div>
        <v-form ref="form" v-model="valid" lazy-validation>
            <!--Create Compoent Begins-->
            <div class="row" v-if="!edit">
                <div class="col align-self-start">
                    <v-select
                        v-model="addQuestion.type"
                        :items="questionType"
                        item-text="name"
                        return-object
                        :rules="[v => !!v || 'Status is required']"
                        label="Type"
                        v-on:change="changeType($event)"
                        solo
                    >
                    </v-select>
                </div>
                <div class="col align-self-center"></div>
                <div class="col align-self-end">
                    <v-text-field
                        v-model="addQuestion.points"
                        min="0"
                        type="number"
                        label="Points"
                        :rules="[v => !!v || 'Point is required']"
                    ></v-text-field>
                </div>
            </div>
            <ckeditor v-if="!edit" v-model="addQuestion.title"></ckeditor>
            <div v-if="showError && !edit" class="v-text-field__details my-2">
                <div class="v-messages theme--light error--text">
                    <div class="v-messages__wrapper">
                        <div class="v-messages__message">
                            Question field is required
                        </div>
                    </div>
                </div>
            </div>
            <v-divider class="mx-2" inset vertical></v-divider>
            <!-- Loop for Options Begins-->
            <div v-for="(option, index) in options" v-if="!edit">
                <div class="input-group">
                    <div class="my-2" v-if="addQuestion.type !== 'Input Type'">
                        <hr />
                    </div>
                    <v-text-field
                        v-if="addQuestion.type !== 'Input Type'"
                        label="Option"
                        v-model="addQuestion.answer[index].answer_title"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-text-field>
                    <!-- Check Box -->
                    <div
                        class="input-group-prepend ml-2 mt-2"
                        v-if="addQuestion.type == 'Multiple Type'"
                    >
                        <input
                            type="checkbox"
                            v-model="addQuestion.answer[index].is_correct"
                            @change="checkCorrect($event, index)"
                            :value="index"
                            class="mt-3 mr-1"
                            name=""
                            id=""
                        /><small class="mt-3">Correct</small>
                    </div>
                    <!-- Radio Button -->
                    <div
                        class="input-group-prepend ml-2 mt-2"
                        v-if="addQuestion.type == 'Single Type'"
                    >
                        <input
                            type="radio"
                            v-model="addQuestion.answer[index].is_correct"
                            class="mt-3 mr-1"
                            name="option"
                            v-on:change="radioOption($event, index)"
                        /><small class="mt-3">Correct</small>
                    </div>
                    <!-- Input Field -->
                    <v-textarea
                        v-if="addQuestion.type == 'Input Type' && index == 0"
                        clearable
                        clear-icon="mdi-close-circle"
                        label="Text"
                        v-model="addQuestion.answer[index].answer_title"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-textarea>

                    <span class="mt-3">
                        <svg
                            v-show="
                                options.length > 1 &&
                                    addQuestion.type !== 'Input Type'
                            "
                            @click="removeField(index, options)"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="#fa314a"
                            viewBox="0 0 30 30"
                            width="24"
                            height="24"
                        >
                            <path
                                d="M 13 3 A 1.0001 1.0001 0 0 0 11.986328 4 L 6 4 A 1.0001 1.0001 0 1 0 6 6 L 24 6 A 1.0001 1.0001 0 1 0 24 4 L 18.013672 4 A 1.0001 1.0001 0 0 0 17 3 L 13 3 z M 6 8 L 6 24 C 6 25.105 6.895 26 8 26 L 22 26 C 23.105 26 24 25.105 24 24 L 24 8 L 6 8 z"
                            />
                        </svg>
                    </span>
                </div>
            </div>
                <!-- Loop for Options End-->
            <!--Create Compoent End-->
            
            <div class="row">
                <div class="text-left mt-3" v-if="addQuestion.type !== 'Input Type'">
                    <v-btn
                        :disabled="!valid"
                        color="success"
                        class="mr-4"
                        @click="submit"
                    >
                        Add Option
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

                    <v-btn color="warning" @click="resetValidation">
                        Reset Form
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
export default {
    data: () => ({
        valid: false,
        edit: false,
        addQuestion: {
            page: 1,
            quiz_id: null,
            title: "",
            points: "",
            type: "",
            answer: [
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                }
            ]
        },
        editQuestion: {
            page: 1,
            quiz_id: null,
            title: "",
            points: "",
            type: "",
            answer: [
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                }
            ]
        },
        questionType: [
            { name: "Single Type" },
            { name: "Multiple Type" },
            { name: "Input Type" }
        ],
        showError: false,
        options: [{ option: "" }]
    }),
    mounted() {
        this.addQuestion.quiz_id = this.$route.params.quiz_id;
       // this.init();
    },
    methods: {
        init() {
            this.options = [{ option: "" }];
            axios
                .get(
                    `/api/questions/${this.$route.params.id}?param=question_id`
                )
                .then(response => {
                    if (
                        response.status === 200 &&
                        Object.keys(response.data).length
                    ) {
                        this.editQuestion = response.data;
                        for (
                            var i = 0;
                            i <= response.data.answer.length - 1;
                            i++
                        ) {
                            let obj = { option: "" };
                        }
                        this.edit = true;
                    }
                });
        },
        submit() {
            if (this.options.length <= 3) {
                this.options.push({ option: "" });
                let obj = {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                };
                this.addQuestion.answer.push(obj);
            }
        },
        resetValidation() {
            this.showError = false;
            this.$refs.form.resetValidation();
        },
        cancel() {
            this.$router.push(`/admin/qizzview/${this.$route.params.quiz_id}`);
        },
        removeField(index, fieldType) {
            if (!this.edit) {
                fieldType.splice(index, 1);
                this.addQuestion.answer.splice(index, 1);
            } else {
                this.editQuestion.answer.splice(index, 1);
            }
        },
        changeType(event) {
            if (this.addQuestion.type == "Input Type") {
                this.options = [{ option: "" }];
            }
            return (this.addQuestion.type = event.name);
        },
        checkCorrect(e, index) {
            if (event.target.checked) {
                this.addQuestion.answer[index].is_correct = true;
            } else {
                this.addQuestion.answer[index].is_correct = false;
            }
        },
        radioOption(event, index) {
            let quizId = this.$route.params.quiz_id;

            this.addQuestion.answer[0].is_correct = false;
            this.addQuestion.answer[1].is_correct = false;
            this.addQuestion.answer[2].is_correct = false;
            this.addQuestion.answer[3].is_correct = false;

            this.addQuestion.answer[index].is_correct = true;
        },
        save() {
            let $chek = this.$refs.form.validate();

            const check = element => element.is_correct === true;
            if (
                this.addQuestion.answer.length < 4 &&
                (this.addQuestion.type == "Single Type" ||
                    this.addQuestion.type == "Multiple Type")
            ) {
                Vue.$toast.open({
                    message: "Four options required",
                    type: "error"
                });
            } else if (!this.addQuestion.answer.some(check) && this.addQuestion.type !== "Input Type") {
                Vue.$toast.open({
                    message: "Atleast one option should be chosen",
                    type: "error"
                });
            } else {
                if (this.addQuestion.title == "") {
                    this.showError = true;
                } else {
                    this.showError = false;
                    axios
                        .post("/api/questions/", this.addQuestion)
                        .then(response => {
                            this.editQuestion = response.data;
                            response.status == 201
                                ? this.$swal(
                                      "Inserted",
                                      "Question has been inserted",
                                      "success"
                                  )
                                : this.errorMsg(response.data.message);
                                this.cancel();
                        })
                        .catch(error => {
                            switch (error.response.status) {
                                case 400:
                                    this.errorMsg(response.data.message);
                                    break;
                                default:
                                    break;
                            }
                        });
                }
            }
        }
    }
};
</script>
