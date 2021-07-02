<template>
    <div>
        <div class="card my-3" v-for="(page,index) in pages" style="width: 50rem;">
            
            <div class="card-header">
                Question {{index+1}}
                <p class="float-right">Points: 1</p>
                <button v-if="!page.options" type="button" class="close" aria-label="Close"  @click="removePage(index, pages)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <p class="m-4">
                    <h3 v-html="page.question"></h3>
                </p>    
                <strong class="mx-4" v-if="page.options">Options: </strong>
                <div class="card m-4" v-if="page.options">
                    
                    <div v-for="(option,index) in page.options">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item font-weight-bold">
                                    <span class="mr-2">{{index+1}}.</span>
                                <v-icon v-if="option.is_correct" small color="success mr-1">done</v-icon>
                                    {{option.answer_title}}
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <span class="" v-if="!page.id">
                    <button class="btn btn-success mx-4" @click="addQuestion()">{{buttonTxt.add}}</button>
                </span>
                <span class=""v-else>
                    <button class="btn btn-success mx-4" @click="editQuestion(page.id)">{{buttonTxt.edit}}</button>
                    <button class="btn btn-danger" @click="deleteQuestion(page.id,index)">Delete</button>
                </span>
                <p class="text-right font-weight-bold">{{page.type}}</p>
                
            </div>
        </div>

        <div class="text-center my-2">
            <button center class="btn btn-primary" @click="addPage()">Add Question</button>
        </div>
    </div>
</template>

<script>
export default {
    data: ()=>({
        pageNumebr:1,
        pages:[],
        // pages: [
        //     {
        //         question: "",
        //         options: {option:"", is_correct: 0},
        //         quiz_id: null,
        //         id:null
        //     },
        // ],
        submitStatus: null,
        buttonTxt: {add:'Add',edit:'Edit'},
    }),
    created(){
        this.init();
    },
    methods: {
        init(){
            axios.get(`/api/questions/${this.$route.params.id}?param=quiz_id`).then(response => {
                console.log(response.data.data);
                this.pages = response.data.data;
            });
        },
        addPage(){
            let newPage = {
                header: 'Page '+this.pageNumebr++,
                question: null,
                options:null
            };

            this.pages.push(newPage);
        },
        removePage(index, fieldType){
            fieldType.splice(index, 1);
        },
        addQuestion(){
            this.$router.push(`/admin/question/${this.$route.params.id}`)
        },
        editQuestion(id){
            this.$router.push(`/admin/question/edit/${id}`);
        },
        deleteQuestion(id,index){
            
            axios.delete(`/api/questions/${id}`).then(response=>{
                this.pages.splice(index, 1);
            });
        }   
    }
}
</script>