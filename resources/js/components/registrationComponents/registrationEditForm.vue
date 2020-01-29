<template>
    <v-card>
        <v-card-title>
        <span class="headline">Edit Registration</span>
        </v-card-title>

        <v-card-text>
            <v-container>
                <v-row>
                <v-col cols="12" sm="12" md="12">
                    <v-text-field
                        type="number"
                        v-model="editedItem.personal_id"
                        :error-messages="editedItemIdentificationErrors"
                        :counter="7"
                        :maxlength="7"
                        label="Personal Identification"
                        required
                        @input="$v.editedItem.personalIdentification.$touch()"
                        @blur="$v.editedItem.personalIdentification.$touch()"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                    <v-text-field
                        v-model="editedItem.first_name"
                        :error-messages="editedItemFirstNameErrors"
                        :counter="50"
                        label="First Name"
                        required
                        @input="$v.editedItem.firstName.$touch()"
                        @blur="$v.editedItem.firstName.$touch()"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                    <v-text-field
                        v-model="editedItem.last_name"
                        :error-messages="editedItemLastNameErrors"
                        :counter="50"
                        label="Last Name"
                        required
                        @input="$v.editedItem.lastName.$touch()"
                        @blur="$v.editedItem.lastName.$touch()"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-text-field
                        v-model="editedItem.email_address"
                        :error-messages="editedItemEmailErrors"
                        label="E-mail"
                        required
                        @input="$v.editedItem.email.$touch()"
                        @blur="$v.editedItem.email.$touch()"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-radio-group label="" v-model="editedItem.brand" row
                        @change="loadShips"
                    >
                        <v-radio label="Azamara" value="A" selected></v-radio>
                        <v-radio label="Celebrity" value="C"></v-radio>
                        <v-radio label="Royal" value="R"></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-select
                        v-model="editedItem.ship"
                        :items="items"
                        :error-messages="editedItemSelectErrors"
                        label="Ship"
                        required
                        @change="$v.editedItem.selectShip.$touch()"
                        @blur="$v.editedItem.selectShip.$touch()"
                        ></v-select>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-menu
                    v-model="editedItemMenuShipDate"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                >
                    <template v-slot:activator="{ on }">
                        <v-text-field
                            v-model="editedItem.sail_date"
                            label="Sail Date"
                            prepend-icon="event"
                            readonly
                            v-on="on"   
                        ></v-text-field>
                    </template>
                    <v-date-picker v-model="editedItem.sail_date"
                        @input="menuShipDate = false"
                        :min=getTomorrowDate
                        required
                        @blur="$v.editedItem.shipDate.$touch()"
                        
                        ></v-date-picker>
                </v-menu> 
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-textarea
                        v-model="editedItem.comments"
                        :error-messages="editedItemCommentsErrors"
                        :counter="500"
                        autocomplete="Comments"
                        label="Comments"
                        @input="$v.editedItem.commentsErrors.$touch()"
                        @blur="$v.editedItem.commentsErrors.$touch()"
                        ></v-textarea>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-checkbox
                        v-model="editedItem.email_list_flag"
                        label="Add to Email List"
                    ></v-checkbox>
                </v-col>
                </v-row>
            </v-container>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required, maxLength, minLength, email } from 'vuelidate/lib/validators'
    import axios from 'axios';
    var tomorrowDate = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().substr(0, 10);

    export default {
        mixins: [validationMixin],
        validations: {
            editedItem: {
                personalIdentification: {required, maxLength: maxLength(7), minLength: minLength(7)},
                firstName: { required, maxLength: maxLength(50) },
                lastName: { required, maxLength: maxLength(50) },
                email: { required, email },
                selectShip: { required },
                shipDate: {required},
                comments:{maxLength: maxLength(500) }
            }  
        },
        data: () => ({
            editedItemMenuShipDate: false,
            editedItem: {
                personal_id: '',
                first_name: '',
                last_name: '',
                email_address: '',
                brand: '',
                ship: null,
                email_list_flag: false,
                brand: 'A',
                sail_date: tomorrowDate,
                comments: '',
            },
            defaultItem: {
                personal_id: '',
                first_name: '',
                last_name: '',
                email_address: '',
                brand: '',
                ship: null,
                email_list_flag: false,
                brand: 'A',
                sail_date: tomorrowDate,
                comments: '',
            },
            items: [
                'Quest',
                'Journey',
                'Pursuit',
            ],

        }),
        computed: {
            editedItemIdentificationErrors(){
                const errors = []
                if (!this.$v.editedItem.personalIdentification.$dirty) return errors
                !this.$v.editedItem.personalIdentification.required && errors.push('Identification is required.')
                !this.$v.editedItem.personalIdentification.maxLength && errors.push('Identification must have 7 numbers!')
                !this.$v.editedItem.personalIdentification.minLength && errors.push('Identification must have 7 numbers!')
                return errors
            },
            editedItemSelectErrors () {
                const errors = []
                if (!this.$v.editedItem.selectShip.$dirty) return errors
                !this.$v.editedItem.selectShip.required && errors.push('Item is required')
                return errors
            },
            editedItemFirstNameErrors () {
                const errors = []
                if (!this.$v.editedItem.firstName.$dirty) return errors
                !this.$v.editedItem.firstName.maxLength && errors.push('First name must be at most 50 characters long')
                !this.$v.editedItem.firstName.required && errors.push('Name is required.')
                return errors
            },
            editedItemLastNameErrors () {
                const errors = []
                if (!this.$v.editedItem.lastName.$dirty) return errors
                !this.$v.editedItem.lastName.maxLength && errors.push('Last name must be at most 50 characters long')
                !this.$v.editedItem.lastName.required && errors.push('Name is required.')
                return errors
            },
            editedItemEmailErrors () {
                const errors = []
                if (!this.$v.editedItem.email.$dirty) return errors
                !this.$v.editedItem.email.email && errors.push('Must be valid e-mail')
                !this.$v.editedItem.email.required && errors.push('E-mail is required')
                return errors
            },
            editedItemCommentsErrors(){
                const errors = []
                if (!this.$v.editedItem.comments.$dirty) return errors
                !this.$v.editedItem.comments.maxLength && errors.push('Comments must be at most 500 characters long')
                return errors
            },
            getTomorrowDate(){
                return new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().substr(0, 10);
            },
        },
        mounted () {
            this.$root.$on('editRegistration', (item) => { 
                this.editedItem = item;
            });

        },

        methods:{
            close () {
                this.$root.$emit('closeDialog', false);
                setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                }, 300)
            },
            loadShips(){
                switch(this.editedItem.brand){
                    case 'A':
                        this.items = ['Quest', 'Journey', 'Pursuit',]
                        break;
                    case 'C':
                        this.items = ['Apex', 'Edge', 'Millennium', 'Summit', 'Equinox', 'Silloutte']
                        break;
                    case 'R':
                        this.items = ['Wonder of the seas', 'Odyssey of the seas', 'Symphony of the seas', 
                                        'Harmony of the seas', 'Oasis of the seas', 'Allure of the seas']
                        break;
                }
            },
            save () {
                 //
                this.$v.editedItem.$touch();
                if (this.$v.editedItem.$pending || this.$v.editedItem.$error) return;

                axios.post('../api/registration', this.editedItem)
                    .then((response) => { 

                    });
                this.$root.$emit('saveDialog', this.editedItem);
                this.close()
            }
        }
    }
</script>