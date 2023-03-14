<style module>
/* Tooltip container */
.tooltip {
  position: relative;
  display: inline-block;
  /* border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  width: 500px;
  background-color: #555;
  color: #fff;
  text-align: justify;
  padding: 5px 10px;
  margin-left: 70px;
  border-radius: 6px;

  /* Position the tooltip text */
  position: absolute;
  z-index: 1;
  left: 50%;

  /* Fade in tooltip */
  opacity: 0;
  transition: opacity 0.3s;
}

/* Tooltip arrow */
.tooltip .tooltiptext::after {
  content: "";
    position: absolute;
    bottom: 85%;
    left: -5px;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent #555 transparent transparent;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
<template>
    <Head>
        <title> Add New Form - Master Form</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> ADD FORM</span>
                            </div>

                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="mb-3">
                                        <label class="fw-bold">Name Table</label>
                                        <input class="form-control" type="text" v-model="form.table_name" placeholder="Name Table">
                                    </div>
                                    <div class="row ms-3">
                                        <div class="col-lg-3">
                                            <input class="form-check-input" type="checkbox" v-model="form.extend" id="extend">
                                            <label class="form-check-label" for="extend">Extend</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-check-input" type="checkbox" v-model="form.status" id="status">
                                            <label class="form-check-label" for="status">Status Report</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-check-input" type="checkbox" v-model="form.customer" id="customer">
                                            <label class="form-check-label" for="customer">Use Customer</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-check-input" type="checkbox" v-model="form.clipboard" id="clipboard">
                                            <label class="form-check-label" for="clipboard">Use Clipboard</label>
                                        </div>
                                    </div>
                                    <div class="row ms-3">
                                        <div>
                                            <input class="form-check-input" type="checkbox" v-model="form.limited" id="limited">
                                            <div :class="$style.tooltip">
                                                <label class="form-check-label" for="limited">Limit Data Access<i class="fa fa-info-circle ms-2"></i></label>
                                                <span :class="$style.tooltiptext">Pembatasan Akses Data.
                                                <li class="ms-3">Aktifkan untuk membatasi data yang dapat di akses oleh user. Data yang sudah di input user hanya dapat di akses oleh user yang bersangkutan.</li>
                                                <li class="ms-3">Matikan batasan akses, untuk membuat data yang sudah di input dapat di akses oleh semua user.</li></span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Role</label>
                                        <br>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <th class="text-center"> Show Data For </th> <th class="text-center"> Create </th> <th class="text-center"> Edit </th> <th class="text-center"> Delete </th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(role, index) in roles" :key="index">
                                                    <td style="padding-left:25px;">
                                                        <input class="form-check-input" type="checkbox" v-model="form.roles" :value="role.name" :id="`check-${role.id}`" @change="check(role)">
                                                        <label class="form-check-label" :for="`check-${role.id}`">{{ role.name }}</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" v-model="form.create" :value="`${role.name}.create`" :id="`create-${role.name}`">
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" v-model="form.edit" :value="`${role.name}.edit`" :id="`edit-${role.name}`">
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" v-model="form.delete" :value="`${role.name}.delete`" :id="`delete-${role.name}`">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- <div class="form-check form-check-inline" v-for="(role, index) in roles" :key="index">
                                            <input class="form-check-input" type="checkbox" v-model="form.roles" :value="role.name" :id="`check-${role.id}`">
                                            <label class="form-check-label" :for="`check-${role.id}`">{{ role.name }}</label>
                                        </div> -->
                                    </div>

                                    <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SAVE</button>
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

    Components: {
        Head,
        Link
    },

    props: {
        roles: Array
    },

    setup() {
        const form = reactive({
            name: '',
            extend:'',
            status:'',
            customer:'',
            clipboard:'',
            roles: [],
            create: [],
            edit: [],
            delete: []
        });

        const submit = () => {
            Inertia.post('/apps/master/forms/new_form', {
                name: form.table_name,
                extend: form.extend,
                status: form.status,
                customer: form.customer,
                clipboard: form.clipboard,
                roles: form.roles,
                create: form.create,
                edit: form.edit,
                delete: form.delete,
            }, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'New Table Created!',
                        icon: 'success',
                        showConfirmButton: true,
                        timer:2000
                    });
                }
            })
        }

        return {
            form,
            submit,
        }
    }
}

</script>