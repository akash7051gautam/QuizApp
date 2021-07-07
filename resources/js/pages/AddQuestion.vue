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
                        
                        <v-layout row wrap v-for="(option, index) in options">
                            <v-flex xs1 class="mt-1">
                                <v-radio-group>
                                    <v-radio
                                        v-for="n in 1"
                                        :key="index"
                                        :value="n"
                                        name="test"
                                    ></v-radio>
                                </v-radio-group>
                            </v-flex>
                            <v-flex xs10>
                                <v-text-field
                                    label="Option 1"
                                    :rules="[v => !!v || 'Option is required']"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs1>
                                <v-btn flat icon color="grey" class="mt-4">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
    
                        <v-layout row wrap>
                            <v-btn @click='add' fab dark color="dark" small :disabled="disabled">
                                <v-icon dark>add</v-icon>
                            </v-btn>
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
            type: "",
            answer: [
                {
                    id: null,
                    answer_title: "",
                    is_correct: false,
                    question_id: null
                }
            ]
        }
    }),
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
        save(){
            console.log(this.addQuestion);
            this.$refs.form.validate()
        }
    },
};
</script>

<style scoped>
.container.grid-list-xl .layout .flex {
    padding: 5px;
}
</style>
