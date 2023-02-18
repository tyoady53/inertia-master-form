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
                                                <select v-model="form.ticket_source" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option value="phone">Phone</option>
                                                    <option value="email">Email</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Department</label>
                                                <select v-model="form.department_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="department in departments" :key="department" :value="department.id">{{ department.name }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Assign To</label>
                                                <select v-model="form.assign_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="user in users" :key="user" :value="user.id">{{ user.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Help Topic *</label>
                                            <select class="form-select" v-model="topic_id" @change="changeTopics">
                                                <option disabled value> Choose One</option>
                                                <!-- <option value="interfacing">Interfacing</option> -->
                                                <option v-for="topic in topics" :key="topic" :value="topic.id">{{ topic.topic_name }}</option>
                                            </select>
                                    </div>
 
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="fw-bold">SLA PLAN</label>
                                                <select v-model="form.sla_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="sla in sla_plans" :key="sla" :value="sla.id">{{ sla.sla_name }} - ({{ sla.sla_hour }} Hours)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">DATE</label>
                                                <input class="form-control" type="time" placeholder="Date" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Priority *</label>
                                                <select v-model="form.priority" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option>Low</option>
                                                    <option>Normal</option>
                                                    <option>High</option>
                                                    <option>Emergency</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Customer *</label>
                                                <select v-model="form.customer_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option value="1">Diagnos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Branch *</label>
                                                <select v-model="form.branch_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option value="1">Margonda</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3" v-if="interfacing == 1">
                                        <label class="fw-bold">Outlet ID</label>
                                        <input class="form-control" type="text" v-model="outlet" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="interfacing == 1">
                                        <label class="fw-bold">Section ID</label>
                                        <input class="form-control" type="text" v-model="section" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="interfacing == 3">
                                        <label class="fw-bold">Section ID</label>
                                        <input class="form-control" type="text" v-model="section" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="module">
                                        <label class="fw-bold">Tag Module *</label>
                                            <select class="form-select">
                                                <option>QMS</option>
                                                <option>Bridging</option>
                                                <option>MCU</option>
                                            </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Summary *</label>
                                        <input v-model="form.title" class="form-control" type="text" rows="4" placeholder="Issue">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Details</label>
                                        <textarea v-model="form.description" class="form-control" type="text" rows="4" placeholder="Details Description"></textarea>
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

    import { reactive } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    import Swal from 'sweetalert2';

    export default {
        layout: LayoutApp,

        components: {
            Head, Link
        },

        props:{
            departments: Array,
            topics: Array,
            users: Array,
            sla_plans: Array
        },

        data: () => ({
            interfacing: '',
        }),

        methods:{
            changeTopics() {
                // for(let i = 0 ; i < topics.length ; i++) {
                //     let structures = this.topics[i];
                //     if(structures['id'] == this.topic_id) {
                //         const a = structures['topic_name'];
                //         console.log(a)
                //         if(a.toLowerCase().includes('interfacing')) {
                //             this.interfacing = true;
                //         } else {
                //             this.interfacing = false;
                //         }
                //     }
                // }
                if(this.topic_id) {
                    this.interfacing = this.topic_id;
                } else {
                    this.interfacing = false;
                }
            }, 
        },

        setup() {

            const form = reactive({
                ticket_source:  '',
                department_id:  '',
                assign_id:      '',
                topic_id:       '',
                sla_id: '',
                priority: '',
                customer_id: '',
                branch_id: '',
                title: '',
                description: ''
            });

            const submit = () => {
                Inertia.post('/apps/master/tickets/store', {
                    ticket_source:  form.ticket_source,
                    department_id:  form.department_id,
                    assign_id:      form.assign_id,
                    topic_id:       form.topic_id,
                    sla_id:         form.sla_id,
                    priority:       form.priority,
                    customer_id:    form.customer_id,
                    branch_id:      form.branch_id,
                    title:          form.title,
                    description:    form.description
                }, {
                    onSuccess: () => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Ticket saved successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }
            return {
            form,
            submit
        }
        }
        
    }
</script>

<style>

</style>