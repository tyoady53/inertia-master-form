<template>
    <Head>
        <title>MANAGE - {{ table_name.description }}</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header input-group">
                                <div class="me-2">
                                <Link :href="`/apps/master/forms/${table_name.name}/show`"><h5><i class="fa fa-arrow-left"></i></h5></Link>
                                </div>
                                <div class="me-2">
                                    <h5><span class="font-weight-bold"><i class="fa fa-cog"></i> MANAGE :: {{ table_name.description }}</span></h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <button data-bs-toggle="modal" data-bs-target="#addFieldModal" class="btn btn-primary btn-sm me-2" type="button">Add Field</button>
                                <!-- <button @click="add_field = true" class="btn btn-primary btn-sm me-2" type="button">Add Field</button> -->
                                <div v-show="add_field" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
                                    <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
                                    <div class="flex items-center justify-between">
                                        <br>
                                        <h3 class="text-2xl">Add Field</h3>
                                    </div>
                                    <div class="mt-4">
                                        <form action="/apps/master/forms/add_column" method="post">
                                            <input class="form-control" :value="table" type="hidden" name="table">
                                            <input type="hidden" name="_token" :value="csrfToken">
                                            <input class="form-control" type="text" name="name">
                                            <select class="form-control" name="data_type">
                                                <option v-for="field in fields" :value="field.datatype">{{ field.name }}</option>
                                            </select>
                                            <br>
                                            <Link href="#" class="btn btn-danger" >Cancel</Link>
                                            <button class="btn btn-success" type="submit">
                                            Save
                                            </button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                <br><br>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <th class="text-center">Field Name</th> <th class="text-center"> Relation </th> <th class="text-center"> Sequence </th> <th class="text-center"> Input Type </th> <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="header in headers">
                                            <td>
                                                <!-- <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editFieldModal" @click="sendInfo(header)"><i class="fa fa-edit"></i></button> -->
                                                {{ header.field_description }}
                                            </td>
                                            <td v-if="header.relation === '0'">
                                                <div v-if="header.input_type.split('#')[0] === 'Parent'">Parent</div>
                                                <div v-else-if="header.input_type.split('#')[0] === 'Child'">Child</div>
                                                <div v-else>. .</div>
                                            </td>
                                            <td v-else>
                                                <div v-for="rel in relation">
                                                    <div v-if="rel.table_name_from == table">
                                                        <div v-if="rel.field_from == header.field_name">
                                                            This Column Have relation with <strong>{{ rel.table_to_desc }}</strong> column <strong>{{ rel.refer_to_desc }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ header.sequence_id }}
                                            </td>
                                            <td class="text-center"> {{ header.input_type }}
                                            </td>
                                            <td class="text-center">
                                                <div>
                                                    <div>
                                                        <button v-if="header.relation === '0'" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#relationModal" @click="sendInfo(header)"> <i class="fa fa-link me-1"></i> Add Relation</button>
                                                        <button v-if="parent_count == '0'" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#parentModal" @click="setParent(header)"> <i class="fas fa-code-branch"></i> Set As Parent</button>
                                                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editFieldModal" @click="sendInfo(header)"><i class="fa fa-edit"></i></button>
                                                        <button @click.prevent="destroy(header.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal Add Relation -->
        <div class="modal" id="relationModal" ref="relationModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Relation : {{ selected_field.field_description }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/apps/master/forms/add_relation" method="POST">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <input class="form-control" name="table" :value="table" type="hidden">
                            <input class="form-control" name="field_from" :value="selected_field.field_name" type="hidden">
                            <input class="form-control" name="table_structure_id" :value="selected_field.id" type="hidden">
                            <div class="mb-3">
                                <select class="form-control" name="relate_table" v-model="selectedChainIds" @change="onChangeChain">
                                    <option v-for="table in avail_tables" :value="table.id">{{ table.description }}</option>
                                </select>
                            </div>
                            <div v-if="filteredChain.length">
                                <label>Refer To Column:</label>
                                <select class="form-control" name="refer_to" v-model="selectedSubChainIds">
                                    <option v-for="chain in filteredChain" :value="chain.field_name">{{ chain.field_description }}</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Update</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
        <!-- End of Modal Add Relation -->

        <!-- The Modal Parent-Child -->
        <div class="modal" id="parentModal" ref="parentModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Set {{ as_parent.field_description }} As Parent</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/apps/master/forms/set_parent" method="POST">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <input class="form-control" name="table" :value="table" type="hidden">
                            <input class="form-control" name="field_name" :value="as_parent.field_name" type="hidden">
                            <div class="mb-3">
                                <label>Select Child</label>
                                <select class="form-control" name="child">
                                    <option v-for="table in filteredParent" :value="table.field_name">{{ table.field_description }}</option>
                                </select>
                            </div>
                            <br>
                            <label>Data From</label>
                            <div class="mb-3">
                                <select class="form-control" name="data_from_table" v-model="parentChainIds" @change="onChangeParent">
                                    <option v-for="table in avail_tables" :value="table.id">{{ table.description }}</option>
                                </select>
                            </div>
                            <div  v-if="filteredChild.length">
                                <div>
                                    <label>Parent Reference</label>
                                    <select class="form-control" name="parent_reference" v-model="parentSubChainIds">
                                        <option v-for="chain in filteredChild" :value="chain.id">{{ chain.field_description }}</option>
                                    </select>
                                    <br>
                                    <label>Child Data</label>
                                    <select class="form-control" name="child_data" v-model="childSubChainIds">
                                        <option v-for="chain in filteredChild" :value="chain.id">{{ chain.field_description }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Update</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
        <!-- End of Modal Parent-Child -->

        <!-- The Modal Add Column -->
        <div class="modal" id="addFieldModal" ref="addFieldModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Column</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/apps/master/forms/add_column" method="post">
                            <input class="form-control" :value="table" type="hidden" name="table">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <input class="form-control" type="text" name="name">
                            <div>
                                <br>
                                <label>Input Type</label>
                                <select class="form-control" name="data_type" v-model="selectedType" @change="onChangeType">
                                    <option v-for="field in fields" :value="field.name" @change="onChangeType">{{ field.name }}</option>
                                </select>
                            </div>
                            <div v-if="filteredTypes.length">
                                <label>Data From</label>
                                <select class="form-control" name="table_to" v-model="selectedChecklistTable" @change="onChangeChecklistTable">
                                    <option v-for="types in filteredTypes" :value="types.id">{{ types.description }}</option>
                                </select>
                                <div v-if="filteredChecklistTable.length">
                                    <label>Select Field</label>
                                    <select class="form-control" id="relate_to_field" name="field_to">
                                        <option v-for="chk in filteredChecklistTable" :value="chk.field_name">{{ chk.field_description }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 m-2">
                                &nbsp
                                <input class="form-check-input" type="checkbox" id="required" name="required">
                                <label class="form-check-label" for="required">Required</label>
                            </div>
                            <div class="col-lg-3 m-2" v-if="table_name.use_clipboard == '1'">
                                &nbsp
                                <input class="form-check-input" type="checkbox" id="can_copy" name="can_copy">
                                <label class="form-check-label" for="can_copy">Can Copy</label>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit"> Save </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
        <!-- End of Modal Add Column -->

        <!-- The Modal Edit Column -->
        <div class="modal" id="editFieldModal" ref="editFieldModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Column</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/apps/master/forms/edit_field/" method="post">
                            <input class="form-control" :value="table" type="hidden" name="table">
                            <input class="form-control" :value="selected_field.id" type="hidden" name="id">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <div>
                                <label>field Name</label>
                                <input class="form-control" type="text" name="field_description" :value="selected_field.field_description">
                            </div>
                            <div>
                                <label>Sequence</label>
                                <input class="form-control" type="text" name="sequence_id" :value="selected_field.sequence_id">
                            </div>
                            <div class="col-lg-3 m-2">
                                &nbsp
                                <div v-if="selected_field.required">
                                    <input class="form-check-input" type="checkbox" checked="checked" id="required" name="required">
                                    <label class="form-check-label" for="required">Required</label>
                                </div>
                                <div v-else>
                                    <input class="form-check-input" type="checkbox" id="required" name="required">
                                    <label class="form-check-label" for="required">Required</label>
                                </div>
                            </div>
                            <div class="col-lg-3 m-2" v-if="table_name.use_clipboard == '1'">
                                &nbsp
                                <div v-if="selected_field.can_copy == '1'">
                                    <input class="form-check-input" type="checkbox" checked="checked" id="can_copy" name="can_copy">
                                    <label class="form-check-label" for="can_copy">Can Copy</label>
                                </div>
                                <div v-else>
                                    <input class="form-check-input" type="checkbox" id="can_copy" name="can_copy">
                                    <label class="form-check-label" for="can_copy">Can Copy</label>
                                </div>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit"> Update </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
        <!-- End of Modal Edit Column -->

        <!-- The Modal Change Data Type -->
        <div class="modal" id="datatypeModal" ref="datatypeModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Change Data Type : {{ selected_type.field_description }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/apps/master/forms/new_field" method="post">
                            <input class="form-control" :value="table" type="hidden" name="table">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <input class="form-control" type="hidden" name="name" :value="selected_type.field_name">
                            <div>
                                <label>Input Type</label>
                                <select class="form-control" name="data_type">
                                    <option v-for="field in fields" :value="field.datatype">{{ field.name }}</option>
                                </select>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit"> Save </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
        <!-- End of Modal Change Data Type -->

    </main>
</template>

<script>
    import LayoutApp from '../../../../Layouts/App.vue';

    import { Head, Link } from '@inertiajs/inertia-vue3';

    import { reactive } from 'vue';

    import { ref } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    import Swal from 'sweetalert2';

    export default {

        layout: LayoutApp,

        components: {
            Head,
            Link
        },

        props: {
            errors: Object,
            roles: Array,
            table: String,
            table_name: Object,
            headers: Array,
            create_data: String,
            edit_data: String,
            delete_data: String,
            forms:Object,
            fields:Array,
            avail_tables: Array,
            structures: Array,
            relation: Array,
            related: Array,
            relate: String,
            csrfToken: String,
            parent_count: Number,
        },

        data: () => ({
            selected_field: '',
            selected_type: '',
            selectedChainIds: -1,
            selectedSubChainIds: -1,
            selected_type: '',
            selectedType: -1,
            selectedSubType: -1,
            selectedChecklistTable: -1,
            selectedFieldChecklist: -1,
            as_parent:'',
            selected_input_type:'',
            child_available: '',
            parent_available: '',
            parentChainIds: -1,
            parentSubChainIds: -1,
            childSubChainIds: -1,
        }),

        methods: {
            sendInfo(header) {
                this.selected_field = header;
            },

            changeType(header) {
                this.selected_type = header;
            },

            setParent(header) {
                this.as_parent = header;
            },

            onChangeType() {
                this.selectedSubType = -1;
                if(!this.selectedType) {
                    this.selectedType = -1;
                }
            },

            onChangeChecklistTable() {
                this.selectedFieldChecklist = -1;
                if(!this.selectedChecklistTable) {
                    this.selectedChecklistTable = -1;
                }
            },

            onChangeChain() {
                this.selectedSubChainIds = -1;
                if(!this.selectedChainIds) {
                    this.selectedChainIds = -1;
                }
            },

            onChangeParent() {
                this.parentSubChainIds = -1;
                if(!this.parentChainIds) {
                    this.parentChainIds = -1;
                }
                this.childSubChainIds = -1;
                if(!this.parentChainIds) {
                    this.parentChainIds = -1;
                }
            }
        },

        computed: {
            filteredChain() {
            let filteredsubChains = [];
            for(let i = 0 ; i < this.structures.length ; i++) {
                let structures = this.structures[i];
                if(structures.table_id == this.selectedChainIds) {
                    filteredsubChains.push(structures);
                }
            }
            return filteredsubChains;
            },

            filteredTypes() {
            let filteredTypeData = [];
            if(this.selectedType == 'Checklist'){
                filteredTypeData.push(this.avail_tables);
                return this.avail_tables;
            }

            return filteredTypeData;
            },

            filteredChecklistTable() {
            let filteredData = [];
            for(let i = 0 ; i < this.structures.length ; i++) {
                let structures = this.structures[i];
                if(structures.table_id == this.selectedChecklistTable) {
                    filteredData.push(structures);
                }
            }
            return filteredData;
            },

            filteredChild() {
            let filteredChildData = [];
            for(let i = 0 ; i < this.structures.length ; i++) {
                let structures = this.structures[i];
                if(structures.table_id == this.parentChainIds) {
                    filteredChildData.push(structures);
                }
            }
            return filteredChildData;
            },

            filteredParent() {
            let filteredParentSelected = [];
            for(let i = 0 ; i < this.structures.length ; i++) {
                let structures = this.structures[i];
                if(structures.table_id == this.as_parent.table_id) {
                    if(structures.id != this.as_parent.id) {
                        filteredParentSelected.push(structures);
                    }
                }
            }
            return filteredParentSelected;
            },
        },

        setup() {
            const form = reactive({
                name: '',
                roles: [],
            });

            const submit = () => {

                Inertia.post('/apps/forms/new_data', {
                    name: form.name,
                    roles: form.roles
                }, {
                    onSuccess: () => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'User saved successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            };

            let add_field = ref(false);

            return {
                add_field,
                form,
                submit,
            };
        }
    }
</script>