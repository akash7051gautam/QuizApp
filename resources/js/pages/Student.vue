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
                                            :rules="
                                            [
                                                    v => !!v || 'Confirm password is required', 
                                                    (this.editedItem.password === this.editedItem.conf_password) || 'Password must match'
                                                ]
                                            "
                                        ></v-text-field>
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
                <td>{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.email }}</td>
                <td class="text-xs-right" v-if="props.item.role">
                    {{ props.item.role.name }}
                </td>
                <td class="text-xs-right" v-else>n/a</td>
                <td class="text-xs-right">{{ props.item.created_at }}</td>
                <td class="justify-center layout px-0"></td>
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
export default {
    data: () => ({
        dialog: false,
        valid: true,
        editIndex: -1,
        headers: [
            { text: "Username", value: "name" },
            { text: "Roll No.", value: "email" },
            { text: "Created", value: "created_at" },
            { text: "Actions", value: "name", sortable: false }
        ],
        tableData: [],
        editedItem: {
            first_name: "",
            last_name: "",
            email: "",
            roll_no: "",
            password: "",
            conf_password: ""
        },
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
            v => !!v || 'Roll number is required'
        ],
        passwordRules:[
            v => !!v || 'Password is required',
            v => (v && v.length >= 8) || 'Min 8 characters'
        ],
        confPasswordRules:[
            v => !!v || 'Confirm password is required',
            v => (v && v.length >= 8) || 'Min 8 characters'
        ],
        password: 'Password',
        
    }),
    methods: {
        close() {
            this.dialog = false;
            this.$refs.form.reset();
        },
        save() {
            if (this.$refs.form.validate()) {
                alert('Succes !');
            }
        },
    },
    computed: {
        formTitle() {
            return this.editIndex === -1 ? "New Item" : "Edit Item";
        }
    }
};
</script>
