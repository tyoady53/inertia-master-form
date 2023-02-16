<template>
    <Head> Tickets - Master Form </Head>
    <main class="c-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded-3 shadow-border-top-purple">
                    <div class="card-header">
                        <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> Ticket</span>
                    </div>
                    <div class="card-body">
                            <form>
                                <div class="input-group mb-3">
                                    <Link href="#" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                                    <input type="text" class="form-control" placeholder="search by ticket id . . .">

                                    <button class="btn btn-primary input-group-text" type="submit"> <i class="fa fa-search me-2"></i> SEARCH</button>
                                </div>
                                <div class="mb-3">
                                    <Link href="#" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> OPEN</Link>
                                    <Link href="#" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> ASSIGNED</Link>
                                    <Link href="#" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> OVERDUE</Link>
                                    <Link href="#" class="btn btn-primary btn-sm me-2"><i class="fa fa-ticket-alt me-1"></i> CLOSED</Link>
                                </div>
                            </form>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Ticket</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Topic</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">From</th>
                                        <th scope="col">Priority</th>
                                        <th scope="col">Assigned To</th>
                                        <th class="text-center" style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">
                                            <Link href="#" class="btn btn-success btn-sm me-2"><i class="fa fa-pencil-alt me-1"></i> EDIT</Link>
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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