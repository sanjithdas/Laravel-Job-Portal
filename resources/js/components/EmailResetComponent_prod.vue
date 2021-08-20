<template>
    <div class="container">
        <form @submit.prevent="submitForm" >
            <div class="form-group">
                <label for="currentemail">Email addressss</label>
                <input type="email" class="form-control" name="currentemail" id="currentemail" v-model="formFields.currentemail" />
                <div v-if="errorFields && errorFields.currentemail" class="text-danger">{{ errorFields.currentemail[0] }}</div>
                <div v-if="errorFields && errorFields.current" class="text-danger">{{ errorFields.current[0] }}</div>
            </div>
            <div class="form-group">
                <label for="email">New email address</label>
                <input type="email" class="form-control" name="email" id="email" v-model="formFields.email" />
                <div v-if="errorFields && errorFields.email" class="text-danger">{{ errorFields.email[0] }}</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" v-model="formFields.password" />
                <div v-if="errorFields && errorFields.password" class="text-danger">{{ errorFields.password[0] }}</div>
                <div v-if="errorFields && errorFields.cpassword" class="text-danger">{{ errorFields.cpassword[0] }}</div>
            </div>
            <div>
                Email is used to sign in to Job4U and to be contacted by employers
            </div>
            <button type="submit" class="ml-5 mt-3 btn btn-primary text-center">Save</button>
            <button type="reset" class="btn mt-3 btn-primary text-center" v-on:click="cancelForm()">Cancel</button>
        </form>
    </div>
</template>
<script>
    export default {
        props:["user","email"],
        data(){
            return{
                formFields: {},
                errorFields: {},
            }
        },
        mounted() {
            this.formFields = {};
            this.userName = this.user;
        },
        methods:{
        cancelForm: function(){
            var tagStyle = document.getElementById('emailreset');
            tagStyle.style.display = "none"
            },

        submitForm: function(){

            axios.post('reset-email',
                this.formFields
            ).then(response => {
                //alert(response.data);
                this.$toaster.success('Email updated successfully');
                this.errorFields={};
                this.formFields = {};
            }).catch(error => {
                // alert('error is '+error.response.data.errors);
                if (error.response.status === 422){
                    this.errorFields = error.response.data.errors || {};
                  //  alert('error is '+this.errorFields.cpassword);
                }


            });
        }
      }
    }
</script>
