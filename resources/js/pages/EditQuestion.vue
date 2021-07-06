<template>
    <div>
        <v-form ref="form" v-model="valid" lazy-validation>
            <div class="row">
                <div class="col align-self-start">
                    <v-select
                        disabled
                        v-model="editQuestion.type"
                        :items="questionType"
                        item-text="name"
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
                        :rules="[v => !!v || 'Point is required']"
                    ></v-text-field>
                </div>
            </div>
            <ckeditor v-model="editQuestion.title"></ckeditor>
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
            <div v-for="(answer, index) in editQuestion.answer">
                <div class="input-group">
                    <div class="my-2" v-if="editQuestion.type !== 'Input Type'">
                        <hr />
                    </div>
                    <v-text-field
                        v-if="editQuestion.type !== 'Input Type'"
                        label="Option"
                        v-model="answer.answer_title"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-text-field>
                    <!-- Check Box -->
                    <div
                        class="input-group-prepend ml-2 mt-2"
                        v-if="editQuestion.type == 'Multiple Type'"
                    >
                        <input
                            type="checkbox"
                            v-model="answer.is_correct"
                            :value="index"
                            class="mt-3 mr-1"
                            name=""
                            id=""
                        /><small class="mt-3">Correct</small>
                    </div>
                    <!-- Radio Button -->
                    <div
                        class="input-group-prepend ml-2 mt-2"
                        v-if="editQuestion.type == 'Single Type'"
                    >
                        <input
                            type="radio"
                            v-model="answer.is_correct"
                            :value="index"
                            class="mt-3 mr-1"
                            name="option"
                            id=""
                        /><small class="mt-3">Correct</small>
                    </div>
                    <!-- Input Field -->
                    <v-textarea
                        v-if="editQuestion.type == 'Input Type' && index == 0"
                        clearable
                        clear-icon="mdi-close-circle"
                        label="Text"
                        :value="editQuestion.answer[index].answer_title"
                        :rules="[v => !!v || 'Option is required']"
                    ></v-textarea>
                </div>
            </div>
            <div class="row">
                <!-- <div
                    class="text-left mt-3"
                    v-if="editQuestion.type !== 'Input Type'"
                >
                    <v-btn
                        :disabled="!valid"
                        color="success"
                        class="mr-4"
                        @click="submit"
                    >
                        Add Option
                    </v-btn>
                </div> -->
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
        showError: false
    }),
    mounted() {
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
                    }
                });
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
        edit() {},
        changeType(event) {
            if (this.editQuestion.type == "Input Type") {
                this.options = [{ option: "" }];
            }
            return (this.editQuestion.type = event.name);
        },
        submit() {
            
        },
        update() {
            console.log(this.editQuestion);//return;
            this.$refs.form.validate();
            if (this.editQuestion.title == "") {
                this.showError = true;
            }else{
                this.showError = false;
                axios
                .put(
                    `/api/questions/${this.$route.params.id}`,
                    this.editQuestion
                )
                .then(response => {
                    if (response.status == 201) {
                        this.successMsg("Updated!", response.data.message);
                    } else {
                        this.errorMsg(response.data.message);
                    }
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
        cancel() {
            this.$router.push(`/admin/qizzview/${this.editQuestion.quiz_id}`);
        },
        successMsg(status, msg) {
            this.$swal(status, msg, "success");
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
