<template>
    <div class="container">
        <form @submit.prevent="submitForm" >
            <div class="form-group">
                <label for="currentpass">Current Password</label>
                <input type="password" class="form-control" name="currentpass" id="currentpass" v-model="formFields.currentpass" />
                <div v-if="errorFields && errorFields.currentpass" class="text-danger">{{ errorFields.currentpass[0] }}</div>
                <div v-if="errorFields && errorFields.current" class="text-danger">{{ errorFields.current[0] }}</div>
            </div>
            <div class="form-group">
                <label for="newpassword">New Password</label>
                <input type="password" class="form-control" name="newpassword" id="newpassword" v-model="formFields.newpassword" />
                <div v-if="errorFields && errorFields.newpassword" class="text-danger">{{ errorFields.newpassword[0] }}</div>
            </div>
            <div class="form-group">
                <label for="confirmpass">Confirm Password</label>
                <input type="password" class="form-control" name="confirmpass" id="confirmpass" v-model="formFields.confirmpass" />
                <div v-if="errorFields && errorFields.confirmpass" class="text-danger">{{ errorFields.confirmpass[0] }}</div>
            </div>

            <button type="submit" class="ml-5 btn btn-primary text-center">Reset Password</button>
            <button type="reset" class="btn btn-primary text-center" v-on:click="cancelForm()">Cancel</button>
        </form>
    </div>
</template>
<script>
    export default {
        props:["user","email","userid"],
        data(){
            return{
                formFields: {},
                errorFields: {},
                userName:'',
                success: false,
                loaded: true,
            }
        },
        mounted: function () {
            this.formFields = {};
            this.userName = this.user;
        },
        methods:{
        cancelForm: function(){
            let tagStyle = document.getElementById('passreset');
            tagStyle.style.display = "none"
            },
         submitForm: function(){
              //  this.formFields ={}
               this.formFields.user = this.userName;
               this.formFields.userid = this.userid;
               axios.post('reset-pass',
                    this.formFields
                    ).then(response => {
                  //alert(response.data);
                   this.$toaster.success('Password updated successfully');
                   this.errorFields={};
                   this.formFields = {};
                }).catch(error => {
                   // alert('error is '+error.response.data.errors);
                    if (error.response.status === 422){
                        this.errorFields = error.response.data.errors || {};
                    }

                });
            }
        }
    }
</script>
