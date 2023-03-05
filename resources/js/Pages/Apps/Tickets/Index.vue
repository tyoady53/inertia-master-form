<template>
    <Head> Tickets - Master Form </Head>
    <main class="c-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded-3 shadow-border-top-purple">
                    <div class="card-header">
                        <span class="font-weight-bold"><i class="fa fa-shield-alt pt-2"></i> Ticket</span>
                        <Link href="/apps/master/tickets/create" class="btn btn-primary float-end"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                    </div>
                    <div class="card-body">
                            <form @submit.prevent="">
                                <!-- <div class="input-group mb-3 float-end">
                                    <Link href="/apps/master/tickets/create" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                                    <input type="text" class="form-control" v-model="search" placeholder="search by ticket id . . .">

                                    <button class="btn btn-primary input-group-text" type="submit"> <i class="fa fa-search me-2"></i> SEARCH</button>
                                </div> -->
                                <div class="input-group mb-3">
                                    <button @click="handleOpen" value="open" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> OPEN</button>
                                    <button @click="handleAssigned" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> ASSIGNED</button>
                                    <button @click="handleOverdue" value="overdue" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> OVERDUE</button>
                                    <button @click="handleClosed" value="closed" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> CLOSED</button>
                                </div>
                            </form>
                            <div style="overflow-x: auto;">
                            <table class="table table-striped table-bordered table-hover overflow-scroll">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ticket</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center" scope="col" style="min-width: 100px;">Topic</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Branch</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">From</th>
                                        <th class="text-center">Priority</th>
                                        <th class="text-center" scope="col" style="width: 12%;">Assigned To</th>
                                        <!-- <th class="text-center" style="width: 10%;">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="d in data" :key="d">
                                        <td class="text-custom">
                                            <Link :href="`/apps/master/tickets/${d.thread_id}/thread`">
                                                {{ d.thread_id }}
                                            </Link>
                                        </td>
                                        <td class="text-custom">{{ d.ticket_date }}</td>
                                        <td class="text-custom">{{ d.topic.topic_name }}</td>
                                        <td class="text-custom">{{ d.customer.customer_name }}</td>
                                        <td class="text-custom">{{ d.branch.customer_branch }}</td>
                                        <td class="text-custom">{{ d.title }}</td>
                                        <td class="text-custom">{{ d.user.name }}</td>
                                        <td class="text-custom">{{ d.priority }}</td>
                                        <td class="text-custom">{{ d.assign.name }}</td>
                                        <!-- <td class="text-center text-custom">
                                            <Link href="#" class="text-custom btn btn-success btn-sm me-2"><i class="fa fa-pencil-alt me-1"></i> OPEN</Link>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
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

    import { ref } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        layout: LayoutApp,

        components: {
            Head, Link
        },

        props: {
            data: Array,
            user: Number
        },

        setup(props) {

            console.log(props.user)

            const open = ref('open' || (new URL(document.location)).searchParams.get('q'));
            const assigned = ref(props.user || (new URL(document.location)).searchParams.get('q'));
            const overdue = ref('overdue' || (new URL(document.location)).searchParams.get('q'));
            const closed = ref('closed' || (new URL(document.location)).searchParams.get('q'));

            const handleOpen = () => {
                Inertia.get('/apps/master/tickets', {
                    q: open.value
                });
            }

            const handleClosed = () => {
                Inertia.get('/apps/master/tickets', {
                    q: closed.value
                });
            }

            const handleAssigned = () => {
                Inertia.get('/apps/master/tickets', {
                    q: assigned.value
                })
            }

            const handleOverdue = () => {
                Inertia.get('/apps/master/tickets', {
                    q: overdue.value
                })
            }

         return {
            // search,
            // assigned,
            // overdue,
            handleOpen,
            handleClosed,
            handleAssigned,
            handleOverdue
        }

        }
        
    }
</script>

<style>

</style>