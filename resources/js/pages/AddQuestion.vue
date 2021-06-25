<template>
    <div>
        <v-form ref="form" v-model="valid" lazy-validation>
            <div class="row" v-if="!edit">
                <div class="col align-self-start">
                    <v-select
                        item-text="t1"
                        item-value="t2"
                        v-model="editSeleted"
                        :items="questionType"
                        :rules="[v => !!v || 'Question type is required']"
                        return-object
                        key="componentKey"
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
                    ></v-text-field>
                </div>
            </div>

            <div class="row" v-if="edit">
                <div class="col align-self-start">
                    <v-select
                        item-text="t1"
                        item-value="t2"
                        v-model="defaultSelected"
                        :items="questionType"
                        :rules="[v => !!v || 'Question type is required']"
                        return-object
                        key="componentKey"
                        v-on:change="changeType($event)"
                        solo
                    >
                    </v-select>
                </div>
                <div class="col align-self-center"></div>
                <div class="col align-self-end">
                    <v-text-field
                        v-model="editQuestion.points"
                        min="0"
                        type="number"
                        label="Points"
                    ></v-text-field>
                </div>
            </div>
            <ckeditor v-if="edit" v-model="editQuestion.title"></ckeditor>
            <ckeditor v-if="!edit" v-model="addQuestion.title"></ckeditor>
            <div v-if="showError" class="v-text-field__details my-2">
                <div class="v-messages theme--light error--text">
                    <div class="v-messages__wrapper">
                        <div class="v-messages__message">
                            Question field is required
                        </div>
                    </div>
                </div>
            </div>

            <v-divider class="mx-2" inset vertical></v-divider>

            <div v-for="(answer, index) in editQuestion.answer" v-if="edit">
                <div class="input-group">
                    <div class="my-2"><hr /></div>
                    <v-text-field
                        label="Option"
                        v-model="answer.answer_title"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-text-field>
                    <div class="input-group-prepend ml-2 mt-2">
                        <input
                            type="checkbox"
                            v-model="answer.is_correct"
                            :value="index"
                            class="mt-3 mr-1"
                            name=""
                            id=""
                        /><small class="mt-3">Correct</small>
                    </div>
                    <span class="mt-3">
                        <svg
                            v-show="editQuestion.answer.length > 1"
                            @click="removeField(index, answer)"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="24"
                            height="24"
                            class="ml-2 cursor-pointer"
                        >
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                fill="#ed1140"
                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                            />
                        </svg>
                    </span>
                </div>
            </div>

            <div v-for="(option, index) in options" v-if="!edit">
                <div class="input-group">
                    <div class="my-2"><hr /></div>
                    <v-text-field
                        label="Option"
                        v-model="addQuestion.answer[index].answer_title"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-text-field>
                    <div class="input-group-prepend ml-2 mt-2">
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
                    <span class="mt-3">
                        <svg
                            v-show="options.length > 1"
                            @click="removeField(index, options)"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="24"
                            height="24"
                            class="ml-2 cursor-pointer"
                        >
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                fill="#ed1140"
                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                            />
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

                    <v-btn color="warning" @click="resetValidation">
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
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

export default {
    data: () => ({
        valid: false,
        defaultSelected: {
            t1: "Multiple Choice",
            t2: "multiple_choice"
        },
        editSeleted: {
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
        addQuestion: {
            page: 1,
            quiz_id: null,
            title: "",
            points: 0,
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
            points: 0,
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
        showError: false,
        options: [
            {
                option: ""
            }
        ],
        edit: false
    }),
    mounted() {
        this.addQuestion.quiz_id = this.$route.params.quiz_id;
    },
    created() {
        this.init();
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
                        console.log(response.data);
                    }
                });
        },
        changeType(event) {
            return (this.addQuestion.type = event.t2);
        },
        checkCorrect(e, index) {
            if (event.target.checked) {
                this.addQuestion.answer[index].is_correct = true;
            } else {
                this.addQuestion.answer[index].is_correct = false;
            }
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
        removeField(index, fieldType) {
            if (!this.edit) {
                fieldType.splice(index, 1);
                this.addQuestion.answer.splice(index, 1);
            } else {
                this.editQuestion.answer.splice(index, 1);
            }
        },
        resetValidation() {
            this.showError = false;
            this.$refs.form.resetValidation();
        },
        cancel() {
            this.$router.push(`/admin/qizzview/${this.$route.params.quiz_id}`);
        },
        save() {
            let $chek = this.$refs.form.validate();
            if (this.addQuestion.title == "") {
                this.showError = true;
            } else {
                this.showError = false;
                if ($chek)
                    axios
                        .post("/api/questions/", this.addQuestion)
                        .then(response => {
                            this.editQuestion = response.data;
                            response.status == 201
                                ? this.successMsg()
                                : this.errorMsg(response.data.message);
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
        },
        update() {
            console.log(this.editQuestion);
            axios
                .put(
                    `/api/questions/${this.$route.params.id}`,
                    this.editQuestion
                )
                .then(response => {
                    response.status == 201
                        ? this.successMsg()
                        : this.errorMsg(response.data.message);
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
        },
        successMsg() {
            this.$swal("Good job!", "Question has been added", "success");
        },
        errorMsg(msg) {
            this.$swal({
                icon: "error",
                title: "Oops...",
                text: msg
            });
        }
    }
};
</script>
