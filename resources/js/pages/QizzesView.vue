<template>
    <div>
        
        <div class="card" style="width: 50rem;">
            <div class="card-header">
                {{pages[0].header}}
            </div>
            <div class="card-body">
                <p class="m-4">
                    {{pages[0].question}}
                </p>
                <strong class="mx-4">Options: </strong>
                <div class="card m-4">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <div  v-for="(page, index) in pages">
                                <div  v-for="(option, index) in page.options">
                                    
                                     <li class="list-group-item">

                                        <v-icon v-if="option.is_correct" small color="success mr-1">done</v-icon>
                                        {{option.option}}
                                     </li>
                                </div>
                            </div>
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
        pageNumebr:2,
        pages: [
            {
                header: 'Page 1',
                question: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, aspernatur quo. Libero debitis dolor illum pariatur ducimus placeat aspernatur necessitatibus inventore omnis eos minima in cum et, natus ad reprehenderit?',
                options: [
                    {option:'lorem ipsem',is_correct:false},
                    {option:'lorem ipsem',is_correct:false},
                    {option:'lorem ipsem',is_correct:true},
                    {option:'lorem ipsem',is_correct:false}
                ]
            },
        ],
        htmlArray: [],
        html:''
    }),

    methods: {
        
        addPage(){
            let i = this.pageNumebr++;
            this.html = `<div class="card" style="width: 50rem;">
                            <div class="card-header">
                                Page ${i++} 
                            </div>
                            <div class="card-body">
                                <p class="m-4">
                                
                                </p>
                                <button class="btn btn-success mx-4" @click="addQuestion()">Add Item</button>
                            </div>
                        </div>`;

            this.htmlArray.push(this.html);
            this.span(this.htmlArray);
        },
        span(html) {
            return html;
        },
        addQuestion(){
            this.$router.push('/admin/question')
        }
    }
}
</script>