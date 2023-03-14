<template>
    <Head>
        <title>Data {{ table.description+' #'+ticket }}</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header input-group mb-3">
                            <div class="me-2">
                                <Link :href="`/apps/master/forms/${table.name}/show`"><h2><i class="fa fa-arrow-left"></i></h2></Link>
                            </div>
                            <div class="me-2">
                                <span class="font-weight-bold"><strong>{{ table.description }} : #{{ data.index_id }}</strong><br>by {{ treat_starter.name }}<br>at {{ data.created_at }}</span>
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
                            <span class="font-weight-bold">{{ d.name }}<br>at {{ d.created_at }}<p v-if="d.status">Status : {{ d.status }}</p></span>
                        </div>
                        <div class="card-body">
                            <p style="white-space: pre-wrap;">{{ d.description }}</p>
                        </div>
                    </div>
                    <div class="card border-0 rounded-3 shadow p-3">
                        <form :action="`/apps/master/forms/${table.name}/add_extend/${ticket}`" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <div>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div v-if="last_status == 'Done'">
                                <input class="form-control" type="hidden" name="status_report" value="Done">
                            </div>
                            <div v-else>
                                <div v-if="use_status == 'yes'">
                                    <div v-if="edit == 'yes'">
                                        <label class="fw-bold">Status Report</label>
                                        <select class="form-control" name="status_report" v-model="lastStatus" required>
                                            <option v-for="option in select_status" :value="option.name">{{option.name}}</option>
                                        </select>
                                    </div>
                                    <div v-else>
                                        <input class="form-control" type="hidden" name="status_report" :value="lastStatus">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <Link :href="`/apps/master/forms/${table.name}/show`" class="btn btn-danger">Back</Link>
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
            edit: String,
            extend: Array,
            headers: Array,
            select_status: Array,
            treat_starter: Object,
            ticket: String,
            table: Object,
            csrfToken: String,
            last_status: String,
            use_status: String,
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