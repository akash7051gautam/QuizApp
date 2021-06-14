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
                    <strong>{{page.question}}</strong>
                </p>
                <strong class="mx-4" v-if="page.options">Options: </strong>
                <div class="card m-4" v-if="page.options">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <!-- <div  v-for="(page, index) in pages"> -->
                                <div  v-for="(option, index) in page.options">
                                     <li class="list-group-item">
                                        <v-icon v-if="option.is_correct" small color="success mr-1">done</v-icon>
                                            {{option.option}}
                                     </li>
                                </div>
                            <!-- </div> -->
                        </ul>
                    </div>
                </div>
                <button class="btn btn-success mx-4" @click="addQuestion()">Add Item</button>
            </div>
        </div>

        <div class="my-2" v-for="(html, index) in htmlArray" v-html="span(`${html}`)" /> 

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
                header: '',
                question: "",
                options: null
            },
        ],
        htmlArray: [],
        html:'',
        submitStatus: null
    }),
    methods: {
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
            this.$router.push(`/admin/question/${this.pageNumebr}`)
        }
    }
}
</script>