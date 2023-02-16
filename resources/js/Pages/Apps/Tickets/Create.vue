<template>
    <Head> Create - Master Form</Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-ticket-alt"></i> ADD NEW TICKET</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Ticket Source *</label>
                                                <select class="form-select">
                                                    <option>Phone</option>
                                                    <option>Email</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Department</label>
                                                <select class="form-select">
                                                    <option>Support</option>
                                                    <option>Marketing</option>
                                                    <option>Report</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Assign To</label>
                                                <select class="form-select">
                                                    <option>Dani</option>
                                                    <option>Devi</option>
                                                    <option>Abi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Help Topic *</label>
                                            <select class="form-select">
                                                    <option>Interfacing</option>
                                                    <option>Lis Cis Module</option>
                                                    <option>Lis Reg Key</option>
                                                    <option>Lis App</option>
                                                    <option>Report & Data</option>
                                                    <option>Adjusment Cis Module</option>
                                                    <option>Other</option>
                                            </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="fw-bold">SLA PLAN</label>
                                                <select class="form-select">
                                                    <option>contoh 1</option>
                                                    <option>contoh 2</option>
                                                    <option>contoh 3</option>
                                                    <option>contoh 4</option>
                                                    <option>contoh 5</option>
                                                    <option>contoh 6</option>
                                                    <option>contoh 7</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">DATE</label>
                                                <input class="form-control" type="datetime-local" placeholder="Date"> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Summary *</label>
                                        <input class="form-control" type="text" rows="4" placeholder="Issue">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Priority *</label>
                                        <select class="form-select">
                                            <option>Low</option>
                                            <option>Normal</option>
                                            <option>High</option>
                                            <option>Emergency</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Details</label>
                                        <textarea class="form-control" type="text" rows="4" placeholder="Details Description"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit">CREATE</button>
                                            <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">RESET</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import LayoutApp from '../../../Layouts/App.vue';

    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        layout: LayoutApp,

        components: {
            Head, Link
        },
    }
</script>

<style>

</style>