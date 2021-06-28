<template>
    <div>
        <v-toolbar dark flat color="grey-lighten">
            <v-toolbar-title>Students</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="700px">
                <v-btn slot="activator" color="primary" dark class="mb-2"
                    >New Item</v-btn
                >
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                     <v-flex xs12>
                                        <v-text-field
                                            v-model="editedItem.first_name"
                                            label="First Name"
                                            :rules="firstNameRules"
                                            required
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field
                                            label="Last Name"
                                            v-model="editedItem.last_name"
                                            :rules="lastNameRules"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field
                                            v-model="editedItem.email"
                                            label="Email"
                                            :rules="emailRules"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field
                                            v-model="editedItem.roll_no"
                                            label="Roll Number"
                                            :rules="roleNoRules"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field
                                            v-model="editedItem.password"
                                            label="Password"
                                            :type="password"
                                            :rules="passwordRules"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field
                                            v-model="editedItem.conf_password"
                                            label="Confirm Password"
                                            :type="password"
                                            :rules="[
                                                v => !!v || 'Confirm password is required', 
                                                (this.editedItem.password === this.editedItem.conf_password) || 'Password must match'
                                            ]"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-select
                                                v-model="editedItem.statusVal"
                                                :items="allStatus"
                                                label="Status"
                                                item-text="name"
                                                @change="checkStatus($event)"
                                                return-object
                                                :rules="[
                                                v => !!v || 'Status is required',
                                                v => (v && this.editedItem.status !== '') || 'Status is required'
                                            ]"
                                                chips
                                        ></v-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click="close"
                                >Cancel</v-btn
                            >
                            <v-btn color="blue darken-1" flat @click="save"
                                >Save</v-btn
                            >
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-toolbar>

        <v-data-table :headers="headers" :items="tableData" class="elevation-1">
            <template slot="items" slot-scope="props">
                <td class="text-xs-left">{{props.item.first_name}}</td>
                <td class="text-xs-left">{{props.item.last_name}}</td>
                <td class="text-xs-left">{{props.item.email}}</td>
                <td class="text-xs-left">{{props.item.roll_no}}</td>
                <td class="text-xs-left">{{props.item.created_at}}</td>
                <td class="justify-center layout px-0">
                    <v-icon small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon small @click="deleteItem(props.item)">
                        delete
                    </v-icon>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default {
    data: () => ({
        dialog: false,
        valid: true,
        editIndex: -1,
        headers: [
            { text: "First Name", value: "first_name" },
            { text: "Last Name", value: "last_name" },
            { text: "Email", value: "email" },
            { text: "Roll No.", value: "roll_no" },
            { text: "Created", value: "created_at" },
            { text: "Actions", value: "name", sortable: false }
        ],
        tableData: [],
        addStudent:{
            first_name:"",
            last_name:"",
            roll_no:"",
            email:"",
            password:"",
            status:false
        },
        defaultSelected: [],
        editedItem: {
            first_name: "",
            last_name: "",
            email: "",
            roll_no: "",
            password: "",
            conf_password: "",
            status: "",
            statusVal:[]
        },
        allStatus:[
            {name: 'active'},
            {name: 'inActive'}
        ],
        firstNameRules:[
            v => !!v || 'First name is required',
            //v => (v && v.length <= 10) || 'Name must be less than 10 characters',
        ],
        lastNameRules:[
            v => !!v || 'Last name is required'
        ],
        emailRules:[
            v => !!v || 'Email is required'
        ],
        roleNoRules:[
            v => !!v || 'Roll number is required',
            v => (v && v.length >= 10) || 'Roll number should be of 10 characters',
            v => (v && v.length <= 10) || 'Roll number should be of 10 characters'
        ],
        passwordRules:[
            v => !!v || 'Password is required',
            v => (v && v.length >= 8) || 'Min 8 characters'
        ],
        confPasswordRules:[
            v => !!v || 'Confirm password is required',
            v => (v && v.length >= 8) || 'Min 8 characters'
        ],
        statusRules:[
            v => !!v || 'Status is required',
            v => (v && this.editedItem.status !== '') || 'Status is required'
        ],
        password: 'Password',
        editedIndex: -1,        
        
    }),
    computed: {
      formTitle() {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item';
      },
    },
    mounted(){
        this.init();
    },
    methods: {
        init(){
            axios.get('/api/students').then(response=>{
                if( response.status === 200 ){
                    this.tableData = response.data.data;
                }
            }).catch(error=>{

            });
        },
        close() {
            this.dialog = false;
            this.$refs.form.reset();
            this.editedIndex = -1;
        },
        checkStatus(e){
            (e.name == 'inActive') ? this.editedItem.status = false : this.editedItem.status = true;
        },
        save() {
            if(this.editedIndex === -1){
                if (this.$refs.form.validate()) {
                    axios.post('/api/students',this.editedItem).then(response=>{
                        if(response.status === 201){
                            this.successMsg("Inserted",response.data.data.message);
                            this.close();
                            this.tableData.push(response.data.data);
                            this.close();
                        }
                    }).catch(error=>{
                        if(error.response.status === 400){
                            var arr = error.response.data.message;
                            for(var i=0; i<=arr.length-1; i++){
                                let instance = Vue.$toast.open({
                                    message:arr[i],
                                    type: 'error'
                                });
                            }
                        }
                    });
                }
            }else{
                if (this.$refs.form.validate()) {
                    Object.assign(
                        this.tableData[this.editedIndex],
                        this.editedItem
                    );
                    axios.put(`/api/students/${this.editedItem.id}`,this.editedItem).then(response=>{
                        if(response.status === 201){
                            this.successMsg("Updated",response.data.message);
                            this.close();
                        }
                    }).catch(error=>{

                    });
                }
            }
            
        },
        deleteItem(item) {
            const index = this.tableData.indexOf(item);
            confirm("Are you sure you want to delete this item?") &&
                this.tableData.splice(index, 1);

            axios
                .delete("/api/students/" + item.id)
                .then(response => console.log(response.data));
        },
        editItem(item) {
            this.editedIndex = this.tableData.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.editedItem.statusVal = {name:(this.editedItem.status)?'active':'inActive'}
            this.dialog = true;
        },
        successMsg(action,msg) {
            this.$swal(
                action+'!',
                    msg,
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
    }
};
</script>
