<template>
    <div class="container mt-5">
        <div class="card card-position">
            <div class="card-header text-center h4">
                {{ '$user->name' }}

                <div class="card-title h6">
                    {{ '$user->email' }}
                </div>
            </div>
            <div class="card-body border-bottom text-blue">
                Change Password
            </div>

            <div class="card-body border-bottom text-blue">
                Change Email
            </div>
            <div class="card-body border-bottom text-blue">
                Delete my account
            </div>

        </div>
        <br><br>
    </div>

</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.xz')
        }
    }
</script>
