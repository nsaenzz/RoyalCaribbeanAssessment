<template>
    <v-row
          justify="center"
        >
        <v-col 
            cols="10"
            >
            <v-data-table
                id="dataTableRegistration"
                :headers="headers"
                :search="search"
                :items="registrations"
                sort-by="firstName"
                class="elevation-1"
            >
                <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>Registration List </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>

                    <v-dialog v-model="dialog" max-width="500px">
                        <RegistrationEditForm></RegistrationEditForm>
                    </v-dialog>

                </v-toolbar>
                </template>
                <template v-slot:item.action="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    edit
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    delete
                </v-icon>
                </template>
                <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
    import axios from 'axios';
    import RegistrationEditForm from "./registrationEditForm";

    var tomorrowDate = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().substr(0, 10);

    export default {
    name: 'registrationListComponent',
    props: {
            source: String,
    },
    components:{
        RegistrationEditForm,
    },
    data: () => ({
        dialog: false,
        search: '',
        headers: [
            { text: 'Personal Identification', align: 'left', value: 'personal_id', },
            { text: 'First Name', value: 'first_name' },
            { text: 'Last Name', value: 'last_name' },
            { text: 'Email', value: 'email_address' },
            { text: 'Brand', value: 'brand' },
            { text: 'Ship', value: 'ship' },
            { text: 'Sail Date', value: 'sail_date' },
            { text: 'Comments', value: 'comments' },
            { text: 'Added Email List', value: 'email_list_flag' },
            { text: 'Actions', value: 'action', sortable: false },
        ],
        registrations: [],
        editedIndex: -1,
        closeDialog: false,
        
    }),
    watch: {
      dialog (val) {
        val || this.closeDialog
      },
    },

    created () {
      this.initialize()

      this.$root.$on('newRegistration', (newRegistration) => {
            this.registrations.push(newRegistration);
      });
      this.$root.$on('closeDialog', (d) => {
            this.dialog = d;
            this.closeDialog = true;
      });
      this.$root.$on('saveDialog', (item) => {
           Object.assign(this.registrations[this.editedIndex], item)
      });
      
    },

    methods: {
        initialize () {
        axios.get('../api/registration')
            .then((response) => { this.registrations = response.data; }
            );
      },

      editItem (item) {
            this.editedIndex = this.registrations.indexOf(item)
            //this.editedItem = Object.assign({}, item);
            this.$root.$emit('editRegistration', item);
            this.dialog = true  
      },

      deleteItem (item) {
        const index = this.registrations.indexOf(item);
        let deletePersonalId = Object.assign({}, item).personal_id
        confirm('Are you sure you want to delete this item?') && this.registrations.splice(index, 1)
        axios.delete(`../api/registration/${deletePersonalId}`)
            .then((response) => { this.registrations = response.data; }
            );
      },

    },
  }
</script>