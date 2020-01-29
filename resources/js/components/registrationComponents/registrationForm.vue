<template>
    <v-row
          justify="center"
        >
        <v-col 
            cols="4"
            >
            <v-snackbar
                v-model="snackbar"
                :color="colorSnackBar"
                :timeout="6000"
                :top="true"
                >
                {{ textSnackBar }}
                <v-btn
                    dark
                    text
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
                </v-snackbar>
            <form
                id="registrationForm"
            >
                <v-text-field
                    type="number"
                    v-model="personalIdentification"
                    :error-messages="identificationErrors"
                    :counter="7"
                    :maxlength="7"
                    label="Personal Identification"
                    required
                    @input="$v.personalIdentification.$touch()"
                    @blur="$v.personalIdentification.$touch()"
                >
                </v-text-field>
                <v-text-field
                    v-model="firstName"
                    :error-messages="firstNameErrors"
                    :counter="50"
                    label="First Name"
                    required
                    @input="$v.firstName.$touch()"
                    @blur="$v.firstName.$touch()"
                >
                </v-text-field>
                <v-text-field
                    v-model="lastName"
                    :error-messages="lastNameErrors"
                    :counter="50"
                    label="Last Name"
                    required
                    @input="$v.lastName.$touch()"
                    @blur="$v.lastName.$touch()"
                >
                </v-text-field>
                <v-text-field
                    v-model="email"
                    :error-messages="emailErrors"
                    label="E-mail"
                    required
                    @input="$v.email.$touch()"
                    @blur="$v.email.$touch()"
                ></v-text-field>
                <p>Brand</p>
                <v-radio-group label="" v-model="brand" row
                    @change="loadShips"
                >
                    <v-radio label="Azamara" value="A" selected></v-radio>
                    <v-radio label="Celebrity" value="C"></v-radio>
                    <v-radio label="Royal" value="R"></v-radio>
                </v-radio-group>
                <v-select
                v-model="selectShip"
                :items="items"
                :error-messages="selectErrors"
                label="Ship"
                required
                @change="$v.selectShip.$touch()"
                @blur="$v.selectShip.$touch()"
                ></v-select>
                <v-menu
                    v-model="menuShipDate"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                >
                    <template v-slot:activator="{ on }">
                        <v-text-field
                            v-model="shipDate"
                            label="Sail Date"
                            prepend-icon="event"
                            readonly
                            v-on="on"   
                        ></v-text-field>
                    </template>
                    <v-date-picker v-model="shipDate"
                        @input="menuShipDate = false"
                        :min=getTomorrowDate
                        required
                        @blur="$v.shipDate.$touch()"
                        
                        ></v-date-picker>
                </v-menu> 
                <v-textarea
                    v-model="comments"
                    :error-messages="commentsErrors"
                    :counter="500"
                    autocomplete="Comments"
                    label="Comments"
                    @input="$v.commentsErrors.$touch()"
                    @blur="$v.commentsErrors.$touch()"
                ></v-textarea>
                <v-checkbox
                v-model="checkbox"
                label="Add to Email List"
                ></v-checkbox>

                <v-btn class="mr-4" @click="submit" color="primary">Save</v-btn>
                <v-btn @click="clear" color="error">clear</v-btn>
            </form>
        </v-col>
    </v-row>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required, maxLength, minLength, email } from 'vuelidate/lib/validators'
    import axios from 'axios';

    var tomorrowDate = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().substr(0, 10);

    export default {
        mixins: [validationMixin],
        validations: {
            personalIdentification: {required, maxLength: maxLength(7), minLength: minLength(7)},
            firstName: { required, maxLength: maxLength(50) },
            lastName: { required, maxLength: maxLength(50) },
            email: { required, email },
            selectShip: { required },
            shipDate: {required},
            comments:{maxLength: maxLength(500) }
        },

        data: () => ({
            personalIdentification: '',
            firstName: '',
            lastName: '',
            email: '',
            selectShip: null,
            items: [
                'Quest',
                'Journey',
                'Pursuit',
            ],
            checkbox: false,
            brand: 'A',
            shipDate: tomorrowDate,
            menuShipDate: false,
            comments: '',
            submitted: false,
            snackbar: false,
            colorSnackBar: '',
            textSnackBar: '',
            // array to hold form errors
            errorsApi: '',
        }),

        computed: {
        identificationErrors(){
            const errors = []
            if (!this.$v.personalIdentification.$dirty) return errors
            !this.$v.personalIdentification.required && errors.push('Identification is required.')
            !this.$v.personalIdentification.maxLength && errors.push('Identification must have 7 numbers!')
            !this.$v.personalIdentification.minLength && errors.push('Identification must have 7 numbers!')
            return errors
        },
        selectErrors () {
            const errors = []
            if (!this.$v.selectShip.$dirty) return errors
            !this.$v.selectShip.required && errors.push('Item is required')
            return errors
        },
        firstNameErrors () {
            const errors = []
            if (!this.$v.firstName.$dirty) return errors
            !this.$v.firstName.maxLength && errors.push('First name must be at most 50 characters long')
            !this.$v.firstName.required && errors.push('Name is required.')
            return errors
        },
        lastNameErrors () {
            const errors = []
            if (!this.$v.lastName.$dirty) return errors
            !this.$v.lastName.maxLength && errors.push('Last name must be at most 50 characters long')
            !this.$v.lastName.required && errors.push('Name is required.')
            return errors
        },
        emailErrors () {
            const errors = []
            if (!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Must be valid e-mail')
            !this.$v.email.required && errors.push('E-mail is required')
            return errors
        },
        commentsErrors(){
            const errors = []
            if (!this.$v.comments.$dirty) return errors
            !this.$v.comments.maxLength && errors.push('Comments must be at most 500 characters long')
            return errors
        },
        getTomorrowDate(){
            return new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().substr(0, 10);
        },
        },

        methods: {
            submit () {
                this.$v.$touch();
                if (this.$v.$pending || this.$v.$error) return;
                
                
                var dataForm = {
                    personal_id: this.personalIdentification,
                    first_name: this.firstName,
                    last_name: this.lastName,
                    email_address: this.email,
                    brand: this.brand,
                    ship: this.selectShip,
                    email_list_flag: this.checkbox ? 1:0,
                    sail_date: this.shipDate,
                    comments: this.comments
                }
                axios.post('../api/registration', dataForm)
                    .then((response) => { 
                        // form submission failed, pass form  errors to errors array
                        this.snackbar = true
                        if(response.data){
                            this.textSnackBar = response.data;
                            this.colorSnackBar = 'error'
                        }
                        else{
                            this.textSnackBar = 'Guest Restristed';
                            this.colorSnackBar = 'success'
                            this.submitted = true;
                            this.$root.$emit('newRegistration', dataForm);
                        }
                    }).then(this.clear () );
                
                 
            },
            clear () {
                this.$v.$reset()
                this.personalIdentification = ''
                this.firstName = ''
                this.lastName = ''
                this.email = ''
                this.selectShip = null
                this.checkbox = false
                this.comments = ''
                this.shipDate = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().substr(0, 10);
                this.errorsApi = ''
            },
            loadShips(){
                switch(this.brand){
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
            }
        },
    }
</script>