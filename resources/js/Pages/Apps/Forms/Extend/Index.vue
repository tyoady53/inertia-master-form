<template>
    <Head>
        <title>Ticket #{{ ticket }}</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header input-group mb-3">
                            <div class="me-2">
                                <Link :href="`/apps/master/forms/${table}/show`"><h2><i class="fa fa-arrow-left"></i></h2></Link>
                            </div>
                            <div class="me-2">
                                <span class="font-weight-bold"><strong>Ticket Number : #{{ data.index_id }}</strong><br>by {{ treat_starter.name }}<br>at {{ data.created_at }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-for="header in headers" :key="header">
                                <div v-if="header.input_type == 'Longtext'">
                                    <label class="fw-bold">{{ header.field_description }}</label>
                                    <p style="white-space: pre-wrap;">{{ data[header.field_name] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 rounded-3 shadow p-3" v-for="d in extend" :key="d">
                        <div class="card-header">
                            <span class="font-weight-bold">{{ d.name }}<br>at {{ d.created_at }}</span>
                        </div>
                        <div class="card-body">
                            {{ d.description }}
                        </div>
                    </div>
                    <div class="card border-0 rounded-3 shadow p-3">
                        <form :action="`/apps/master/forms/${table}/add_extend/${ticket}`" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <div>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div v-if="last_status == 'Done'">
                                <input class="form-control" type="hidden" name="status_report" value="Done">
                            </div>
                            <div v-else>
                                <label class="fw-bold">Status Report</label>
                                <select class="form-control" name="status_report" v-model="lastStatus" required>
                                    <option v-for="option in select_status" :value="option.name">{{option.name}}</option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import LayoutApp from '../../../../Layouts/App.vue';

    import { Head, Link } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';

    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutApp,

        //register component
        components: {
            Head,
            Link
        },

        props: {
            data: Object,
            extend: Array,
            headers: Array,
            select_status: Array,
            treat_starter: Object,
            ticket: String,
            table: String,
            csrfToken: String,
            last_status: String,
        },

        data: (props) => ({
            lastStatus: props.last_status,
        }),

        setup() {

        const destroy = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {

                    Inertia.delete(`/apps/roles/${id}`);

                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Role deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            })
        }

        return {
            destroy
        }
    }
}
</script>