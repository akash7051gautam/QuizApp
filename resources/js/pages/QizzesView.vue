<template>
    <div>
        <div class="card my-3" v-for="(page,index) in pages" style="width: 50rem;">
            <div class="card-header">
                Page {{index+1}}
                <button v-if="!page.options" type="button" class="close" aria-label="Close"  @click="removePage(index, pages)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <p class="m-4">
                    <div v-html="page.question"></div>
                </p>    
                <strong class="mx-4" v-if="page.options">Options: </strong>
                <div class="card m-4" v-if="page.options">
                    
                    <div v-for="(option,index) in page.options">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item font-weight-bold">
                                <v-icon v-if="option.is_correct" small color="success mr-1">done</v-icon>
                                    {{option.option}}
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
                </span>
                
            </div>
        </div>

        <div class="text-center my-2">
            <button center class="btn btn-primary" @click="addPage()">Add Page</button>
        </div>
    </div>
</template>

<script>
export default {
    data: ()=>({
        pageNumebr:1,
        pages: [
            {
                question: "",
                options: {option:"", is_correct: 0},
                quiz_id: null,
                id:null
            },
        ],
        submitStatus: null,
        buttonTxt: {add:'Add Page',edit:'Edit Page'},
    }),
    created(){
        this.init();
    },
    methods: {
        init(){
            axios.get(`/api/questions/${this.$route.params.id}`).then(response => {
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
            //this.$router.push(`/admin/question/${this.pageNumebr}/${this.$route.params.id}`)
            this.$router.push(`/admin/question/${this.$route.params.id}/${this.$route.params.id}`)
        },
        editQuestion(pageId){
            this.$router.push(`/admin/question/${pageId}/${this.$route.params.id}`);
        }   
    }
}
</script>