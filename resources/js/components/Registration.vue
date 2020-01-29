<template>
    <v-app id="registration">  
        <RegistrationForm></RegistrationForm>
        <RegistrationList></RegistrationList>
    </v-app>
</template>

<script>
    import RegistrationForm from "./registrationComponents/registrationForm";
    import RegistrationList from "./registrationComponents/regisrationList";

    export default {
        props: {
        source: String,
        },
        components:{
            RegistrationForm,
            RegistrationList,
        },
    }
</script>
