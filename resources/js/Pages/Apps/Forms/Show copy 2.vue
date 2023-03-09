<template>
    <Head>
        <title>Form {{ table_name.description }}</title>
    </Head>
    <div class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <h5><span class="font-weight-bold"><i class="fa-fa-shield-alt"></i>Form {{ table_name.description }}</span></h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="input-group mb-3">
                                        <Link href="#" v-if="hasAnyPermission([create_data])" class="btn btn-primary input-group-text" data-bs-toggle="modal" data-bs-target="#add_dataModal" @click="newData"> <i class="fa fa-plus-circle me-2"></i> Add Data</Link>
                                        <input type="text" class="form-control" placeholder="Search Data">

                                        <button class="btn btn-primary input-group-text" type="submit"> <i class="fa fa-search me-2"></i> SEARCH</button>
                                    </div>
                                    <div class="input-group mb-3" >
                                        <div class="input-group mb-3" v-if="hasAnyPermission(['form.create'])">
                                            <Link :href="`/apps/master/forms/${table}/manage`" class="btn btn-primary input-group-text"> <i class="fa fa-edit me-2"></i> Manage Form</Link>
                                        </div>
                                    </div>
                                </form>
                                <div style="overflow-x:auto;">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th class="text-center" v-if="extend == '1'"> #ID </th>
                                            <th class="text-center" v-for="header in headers" :key="header"> {{ header.field_description }}</th>
                                            <th class="text-center" v-if="status_report == '1'">Status</th>
                                            <th class="text-center" v-if="extend == '1'"> Action </th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="form in forms" :key="form">
                                                <template v-if="table == 'master_customer_branches'">
                                                    <td>
                                                        {{ form.outlet_id }}
                                                    </td>
                                                    <td>
                                                        {{ form.customer_name }}
                                                    </td>
                                                    <td>
                                                        {{ form.customer_branch }}
                                                    </td>
                                                </template>
                                                <template v-else>
                                                    <td class="text-center" v-if="extend == '1'" style="width:130px;">
                                                        <Link :href="`/apps/master/forms/${table}/extend/${form.index_id}`" v-if="form['index_id']" class="btn btn-success btn-sm me-2"><i class="fa fa-expand"></i> {{ form.index_id }}</Link>
                                                    </td>
                                                    <td v-for="header in headers" :key="header">
                                                        <div v-if="header.input_type.split('#')[0] === 'Parent'">
                                                            <div v-for="parent,index in parentData">
                                                                <div v-if="header.relate_to.split('#')[0] == index">
                                                                    <div v-for="p in parent">
                                                                        <div v-if="p.id == form[header.field_name]">
                                                                            {{ p[header.relate_to.split('#')[1]] }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.input_type.split('#')[0] === 'Child'">
                                                            <div v-for="child in child_data">
                                                                <div v-if="form[header.field_name] == child.id">
                                                                    {{ child[header.relate_to.split('#')[1]] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.relation === '1'">
                                                            <div v-if="header.relate_to.includes('R.')">
                                                                <div v-for="rel_data in relation">
                                                                    <div v-if="rel_data.relation_id == header.relate_to">
                                                                        <div v-for="rel,index in related">
                                                                            <div v-if="index == header.relate_to">
                                                                                <div v-for="option in rel">
                                                                                    <div v-if="option.id == form[header.field_name]">
                                                                                        {{option[rel_data.refer_to]}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div v-if="header.relate_to">
                                                                <div v-for="rel,index in related" :key="rel">
                                                                    <div v-if="relation[0].refer_to ==  index">
                                                                        <div v-for="r in rel" :key="r">
                                                                            <div v-if="r.id == form[header.field_name]">
                                                                                {{ r[index] }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-else>
                                                                <div>
                                                                    <div v-for="rel,index in related" :key="rel">
                                                                        <div v-if="relation[0].field_from ==  index">
                                                                            <div v-for="r in rel" :key="r">
                                                                                <div v-if="r.id == form[header.field_name]">
                                                                                    {{ r[relation[0].refer_to] }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                        <div v-else-if="header.relate_to === 'Customers#Parent'">
                                                            <div v-for="r in data['parent']" :key="r">
                                                                <div v-if="r.id == form[header.field_name]">
                                                                    {{ r.customer_name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.relate_to === 'Customers#Child'">
                                                            <div v-for="r in data['child']" :key="r">
                                                                <div v-if="r.id == form[header.field_name]">
                                                                    {{ r.customer_branch }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Today Date'">
                                                            {{ form.created_at }}
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Longtext'">
                                                            <div v-if="form[header.field_name].length > 100">
                                                                <p>{{ form[header.field_name].substring(0,100)+' ...' }}</p>
                                                            </div>
                                                            <div v-else>
                                                                {{ form[header.field_name] }}
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.input_type === 'File'">
                                                            <div v-if="form[header.field_name]">
                                                                <a :href="`/storage/${form[header.field_name]}`" target="_blank" >{{ "..."+form[header.field_name].substring(form[header.field_name].length-15,form[header.field_name].length) }}</a>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            {{ form[header.field_name]  }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ form.status_report }}</td>
                                                    <td class="text-center">
                                                        <div v-if="table_name.use_clipboard == '1'">
                                                            <button class="btn btn-success btn-sm me-2" @click="copy(form.id)">Copy</button>
                                                        </div>
                                                        <!-- <div v-if="extend == '1'" >
                                                            <Link :href="`/apps/master/forms/${table}/extend/${form.index_id}`" v-if="form['index_id']" class="btn btn-success btn-sm me-2"><i class="fa fa-expand"></i> Open Data</Link>
                                                        </div> -->
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- The Modal Add Colum -->
                        <div class="modal" id="addModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Column : {{ table_name.description }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="/apps/master/forms/add_column" method="POST">
                                            <input class="form-control" :value="table" type="hidden" name="table">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <div class="mb-3">
                                                <label class="fw-bold">Name Column</label>
                                                <input class="form-control" type="text" name="name" placeholder="Name Column">
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-control" name="data_type">
                                                    <option v-for="field in fields" :key="field" :value="field.datatype">{{ field.name }}</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SAVE</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal Add Column -->

                        <!-- The Modal Add Data [NEW]-->
                        <div class="modal" id="add_dataModal" ref="add_dataModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Data : {{ table_name.description }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <!-- {{ data['parent'] }} -->
                                        <form action="/apps/master/forms/new_data" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" :value="csrfToken">
                                            <input class="form-control" name="table" :value="table" type="hidden">
                                            <input class="form-control" name="data_id" :value="selectedUser.id" type="hidden">
                                            <div template v-if="table == 'master_customer_branches'">
                                                <input class="form-control" name="status" value="0" type="hidden">
                                                <div class="mb-3">
                                                    <label class="fw-bold">Outlet ID</label>
                                                    <input type="text" name="outlet_id" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold">Select Customer</label>
                                                    <select class="form-control" name="customer_id">
                                                        <option v-for="option in data['parent']" :value="option.id">{{option.customer_name}}</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="fw-bold">Input Branch</label>
                                                    <input type="text" name="customer_branch" class="form-control">
                                                </div>
                                            </div>
                                            <div v-else>
                                                <!-- {{ relation }} -->
                                                <div class="mb-3" v-for="header in headers" :key="header">
                                                    <div v-if="relate === 'yes'">
                                                        <div v-if="header.relation == '1'">
                                                            <div v-if="header.relate_to.includes('R.')">
                                                                <div v-for="rel_data in relation">
                                                                    <div v-if="rel_data.relation_id == header.relate_to">
                                                                        <div v-for="rel,index in related">
                                                                            <div v-if="index == header.relate_to">
                                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                                <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                                    <option v-for="option in rel" :value="option.id">{{option[rel_data.refer_to]}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div>
                                                                    <div v-for="rel_data in relation">
                                                                        <div v-if="rel_data.field_from == header.field_name">
                                                                            <div v-for="rel,index in related">
                                                                                <div v-if="index == header.field_name">
                                                                                    <label class="fw-bold">{{ header.field_description }} 2</label>
                                                                                    <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                                        <option v-for="option in rel[header.field_name]" :value="option.id">{{option[rel_data.refer_to]}}</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                            <div v-else>
                                                                <div v-if="relation[0].table_name_from == 'master_customer_branches'">
                                                                    <div v-for="rel,index in related" :key="r">
                                                                        <div v-if="index == 'customer_id'">
                                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                                            <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                                <option v-for="option in rel" :value="option.id">{{option.customer_name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <div v-for="rel_data in relation">
                                                                        <div v-if="rel_data.field_from == header.field_name">
                                                                            <div v-for="rel,index in related">
                                                                                <div v-if="index == header.field_name">
                                                                                    <label class="fw-bold">{{ header.field_description }}</label>
                                                                                    <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                                        <option v-for="options in rel" :value="options.id">{{options[rel_data.refer_to]}}</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <div v-if="header.input_type === 'Text'">
                                                                <div v-if="header.relate_to == 'Customers#Parent'">
                                                                    <label class="fw-bold">{{ header.field_description }}</label>{{ index }}
                                                                    <select class="form-control" :name="header.field_name" v-model="customerIds" @change="customer_change" :required="header.required == 'required'">
                                                                        <option v-for="option in data[['parent']]" :value="option.id">{{option.customer_name}}</option>
                                                                    </select>
                                                                </div>
                                                                <div v-else-if="header.relate_to == 'Customers#Child'">
                                                                    <label class="fw-bold">{{ header.field_description }}</label>
                                                                    <select class="form-control" :name="header.field_name" v-model="selectedCustomerIds">
                                                                        <option v-for="option in filteredCustomer" :value="option.id">{{option.customer_branch}}</option>
                                                                    </select>
                                                                </div>
                                                                <div v-else>
                                                                    <label class="fw-bold">{{ header.field_description }}</label>
                                                                    <input class="form-control" :name="header.field_name" type="text" :placeholder="header.field_description" :required="header.required == 'required'">
                                                                </div>
                                                            </div>
                                                            <div v-else-if="header.input_type === 'Number'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <input class="form-control" :name="header.field_name" type="number" :placeholder="header.field_description" :required="header.required == 'required'">
                                                            </div>
                                                            <div v-else-if="header.input_type === 'Time'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <input class="form-control" :name="header.field_name" type="time" :placeholder="header.field_description" :required="header.required == 'required'">
                                                            </div>
                                                            <div v-else-if="header.input_type === 'Date'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <input class="form-control" :name="header.field_name" type="date" :placeholder="header.field_description" :required="header.required == 'required'">
                                                            </div>
                                                            <div v-else-if="header.input_type === 'File'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <input class="form-control" :name="header.field_name" type="file" :placeholder="header.field_description" :required="header.required == 'required'">
                                                            </div>
                                                            <div v-else-if="header.input_type === 'Yes/No'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                    <option value="1">Yes</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>
                                                            <div v-else-if="header.input_type === 'Checklist'">
                                                                <div v-for="(checklist,index) in checklist_data" :key="index">
                                                                    <div v-if="header.relate_to.split('#')[0] == index">
                                                                        <table class="table table-striped table-bordered table-hover">
                                                                            <thead>
                                                                                <th class="text-center" colspan="2"> {{ header.field_description }} </th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="check in checklist">
                                                                                    <td>
                                                                                        {{check[header.relate_to.split('#')[1]]}}
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <input type="checkbox" :name="header.field_name+'[]'" :value="check[header.relate_to.split('#')[1]]" :required="header.required == 'required'">
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-else-if="header.input_type === 'Longtext'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <!-- <Editor
                                                                :name="header.field_name"
                                                                api-key="no-api-key"
                                                                    :init="{
                                                                        menubar: false,
                                                                        plugins: 'code emoticons preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link codesample charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars',
                                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | code | emoticons |',
                                                                    }">
                                                                </Editor> -->
                                                                <textarea class="form-control" :name="header.field_name" type="number" :placeholder="header.field_description" :required="header.required == 'required'"></textarea>
                                                            </div>
                                                            <div v-else-if="header.input_type.includes('#')">
                                                                <div v-if="header.input_type.split('#')[0] === 'Parent'">
                                                                    <div v-for="parent,index in parentData">
                                                                        <div v-if="header.relate_to.split('#')[0] == index">
                                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                                            <select class="form-control" :name="header.field_name" v-model="selectedChainIds" @change="onChangeChain(header.input_type.split('#')[1])" :required="header.required == 'required'">
                                                                                <option v-for="p in parent" :value="p.id">{{ p[header.relate_to.split('#')[1]] }}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div v-else-if="header.input_type.split('#')[0] === 'Child'">
                                                                    <div  v-if="filteredChain.length">
                                                                        <label class="fw-bold">{{ header.field_description }}</label>
                                                                        <select class="form-control" :name="header.field_name" v-model="selectedSubChainIds" :required="header.required == 'required'">
                                                                            <option v-for="chain in filteredChain" :value="chain.id">{{ chain[header.relate_to.split('#')[1]] }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-if="relate ==='no'">
                                                        <div v-if="header.input_type === 'Text'">
                                                            <div v-if="header.relate_to == 'Customers#Parent'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>{{ index }}
                                                                <select class="form-control" :name="header.field_name" v-model="customerIds" @change="customer_change" :required="header.required == 'required'">
                                                                    <option v-for="option in data[['parent']]" :value="option.id">{{option.customer_name}}</option>
                                                                </select>
                                                            </div>
                                                            <div v-else-if="header.relate_to == 'Customers#Child'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <select class="form-control" :name="header.field_name" v-model="selectedCustomerIds">
                                                                    <option v-for="option in filteredCustomer" :value="option.id">{{option.customer_branch}}</option>
                                                                </select>
                                                            </div>
                                                            <div v-else>
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <input class="form-control" :name="header.field_name" type="text" :placeholder="header.field_description" :required="header.required == 'required'">
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Number'">
                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                            <input class="form-control" :name="header.field_name" type="number" :placeholder="header.field_description" :required="header.required == 'required'">
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Time'">
                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                            <input class="form-control" :name="header.field_name" type="time" :placeholder="header.field_description" :required="header.required == 'required'">
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Date'">
                                                            <label class="fw-bold">{{ header.field_description }} {{ header.required }}</label>
                                                            <input class="form-control" :name="header.field_name" type="date" :placeholder="header.field_description" :required="header.required == 'required'">
                                                        </div>
                                                        <div v-else-if="header.input_type === 'File'">
                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                            <input class="form-control" :name="header.field_name" type="file" :placeholder="header.field_description" :required="header.required == 'required'">
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Longtext'">
                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                            <!-- <Editor
                                                            :name="header.field_name"
                                                            api-key="no-api-key"
                                                                :init="{
                                                                    menubar: false,
                                                                    plugins: 'code emoticons preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link codesample charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars',
                                                                    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | code | emoticons |',
                                                                }">
                                                            </Editor> -->
                                                            <textarea class="form-control" :name="header.field_name" type="number" :placeholder="header.field_description" :required="header.required == 'required'"></textarea>
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Yes/No'">
                                                            <label class="fw-bold">{{ header.field_description }}</label>
                                                            <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                <option value="1">Yes</option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>
                                                        <div v-else-if="header.input_type === 'Checklist'">
                                                            <div v-for="(checklist,index) in checklist_data" :key="index">
                                                                <div v-if="header.relate_to.split('#')[0] == index">
                                                                    <table class="table table-striped table-bordered table-hover">
                                                                        <thead>
                                                                            <th class="text-center" colspan="2"> {{ header.field_description }} </th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="check in checklist[index]">
                                                                                <td>
                                                                                    {{check[header.relate_to.split('#')[1]]}}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <input type="checkbox" :name="header.field_name+'[]'" :value="check[header.input_type.split('#')[1]]" :required="header.required == 'required'">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else-if="header.input_type.includes('#')">
                                                            <div v-if="header.input_type.split('#')[0] === 'Parent'">
                                                                <div v-for="parent,index in parentData">
                                                                    <div v-if="header.relate_to.split('#')[0] == index">
                                                                        <label class="fw-bold">{{ header.field_description }}</label>
                                                                        <select class="form-control" :name="header.field_name" v-model="selectedChainIds" @change="onChangeChain(header.input_type.split('#')[1])" :required="header.required == 'required'">
                                                                            <option v-for="p in parent" :value="p.id">{{ p[header.relate_to.split('#')[1]] }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-else-if="header.input_type.split('#')[0] === 'Child'">
                                                                <div  v-if="filteredChain.length">
                                                                    <label class="fw-bold">{{ header.field_description }}</label>
                                                                    <select class="form-control" :name="header.field_name" v-model="selectedSubChainIds" :required="header.required == 'required'">
                                                                        <option v-for="chain in filteredChain" :value="chain.id">{{ chain[header.relate_to.split('#')[1]] }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <input class="form-control" :name="header.field_name" type="text" :placeholder="header.field_description"> -->
                                                    <!-- <div v-if="table_name.use_customer == '1'">
                                                        <div v-for="rel,index in data" :key="index">
                                                            <div v-if="index == 'parent'">
                                                                <label class="fw-bold">{{ header.field_description }}</label>
                                                                <select class="form-control" :name="header.field_name" :required="header.required == 'required'">
                                                                    <option v-for="option in rel" :value="option.id">{{option.customer_name}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <div v-if="status_report == '1'">
                                                        <label class="fw-bold">Status</label>
                                                        <select class="form-control" name="status_report" required>
                                                            <option v-for="option in select_status" :value="option.name">{{option.name}}</option>
                                                        </select>
                                                    </div>
                                                    <div v-if="extend == '1'">
                                                        <div>&nbsp&nbsp&nbsp&nbsp
                                                            <input class="form-check-input" type="hidden" value="1" id="create_ticket" name="create_ticket">
                                                        </div>
                                                    </div>
                                                    <div v-if="create_ticket">
                                                        <div>
                                                            <label class="fw-bold">Assign By</label>
                                                            <select class="form-control" name="assignSelector" v-model="assignSelector" @change="onChangeAssign">
                                                                <option value="division">Division</option>
                                                                <option value="user">Users</option>
                                                            </select>
                                                        </div>
                                                        <div  v-if="filteredAssign.length">
                                                            <label class="fw-bold">Assign to</label>
                                                            <select class="form-control" name="assign_to" v-model="selectedAssign">
                                                                <option v-for="chain in filteredAssign" :key="chain" :value="chain.id">{{ chain.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Save</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal Add Data -->

                        <!-- The Modal Edit Data -->
                        <div class="modal" id="editModal" ref="editModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update Data : {{ table_name }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="/apps/master/forms/update_data" method="POST">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <input class="form-control" name="table" :value="table" type="hidden">
                                            <input class="form-control" name="data_id" :value="selectedUser.id" type="hidden">
                                            <div class="mb-3" v-for="header in headers" :key="header">
                                                <label class="fw-bold">{{ header.field_name }}</label>
                                                <input class="form-control" :name="header.field_name" :value="selectedUser[header.field_name]" type="text" :placeholder="header.field_description">
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
                        <!-- End of Modal Edit Data -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutApp from '../../../Layouts/App.vue';

import { Head, Link } from '@inertiajs/inertia-vue3';

import { Inertia } from '@inertiajs/inertia';

import Editor from '@tinymce/tinymce-vue';

import Swal from 'sweetalert2';

export default {
    layout: LayoutApp,

    components: {
            Head,
            Link,
            Editor
        },

    props: {
        table: String,
        roles: Array,
        today: String,
        status_report: String,
        extend: String,
        table_name: String,
        headers: Object,
        create_data: String,
        edit_data: String,
        delete_data: String,
        relation: Array,
        related: String,
        relate: String,
        forms:Object,
        csrfToken: String,
        parentData: Array,
        child_data: Array,
        checklist_data: Object,
        divisions: Array,
        select_status: Array,
        users: Array,
        data: Array,
    },

    data: () => ({
        selectedUser: '',
        sel:[],
        selected:[],
        parent:'',
        selectedChainIds: -1,
        selectedSubChainIds: -1,
        customerIds: -1,
        selectedCustomerIds: -1,
        assignSelector: -1,
        selectedAssign: -1,
        create_ticket : false,
    }),

    methods: {
        copy(id){
            var UrlOrigin = window.location.origin;
            let parent_data = [];
            let parent = [];
            let clipboard_val = '';
            let data = '';
            let parent_key = '';
            for(let j = 0 ; j < this.forms.length ; j++) {
                let datas = this.forms[j];
                if(datas.id == id){
                    for(let i = 0 ; i < this.headers.length ; i++) {
                        let header = this.headers[i];
                        if(header.input_type.split('#')[0] === 'Parent'){
                            parent_key = Object.keys(this.parentData)[0];
                            parent_data = this.parentData[parent_key]
                            if(header.relate_to.split('#')[0] == parent_key){
                                for(let k = 0; k < parent_data.length; k++){
                                    parent = parent_data[k];
                                    if(parent.id == datas[header.field_name]){
                                        clipboard_val += header.field_description + ' : '+parent[header.relate_to.split('#')[1]]+'\n';
                                    }
                                }
                            }
                        }
                        else if(header.input_type.split('#')[0] === 'Child'){
                            for(let l = 0; l < this.child_data.length; l++){
                                let child = this.child_data[l]
                                if(datas[header.field_name] == child.id){
                                    clipboard_val += header.field_description + ' : '+child[header.relate_to.split('#')[1]]+'\n';
                                }
                            }
                        }
                        else if(header.relation === '1'){
                            let sel = '';
                            parent_key = Object.keys(this.related);
                            for(let p=0;p < parent_key.length;p++){
                                let key = parent_key[p]
                                if(header.relate_to == key){
                                    let data = this.related[key]
                                    for(let q = 0; q < data.length;q++){
                                        let rel = data[q]
                                        if(rel.id == datas[header.field_name]){
                                            for(let r = 0; r < this.relation.length; r++){
                                                sel = this.relation[r]
                                                if(sel.relation_id == header.relate_to){
                                                    clipboard_val += header.field_description + ' : '+rel[sel.refer_to]+'\n';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else if(header.input_type == 'Today Date'){
                            clipboard_val += header.field_description + ' : '+header.created_at+'\n';
                        }
                        else if(header.input_type == 'Longtext'){
                            clipboard_val += header.field_description + ' :\n'+datas[header.field_name]+'\n';
                        }
                        else if(header.input_type == 'File'){
                            if(datas[header.field_name]){
                                clipboard_val += header.field_description + ' : '+UrlOrigin+'/storage/'+datas[header.field_name]+'\n';
                            }
                        }
                        else{
                            if(header.relate_to){
                                if(header.relate_to == 'Customers#Parent'){
                                    let parents_data = this.data['parent']
                                    for(let m = 0; m < parents_data.length; m++){
                                        let parent = parents_data[m]
                                        if(datas[header.field_name] == parent.id){
                                            clipboard_val += header.field_description + ' : '+parent.customer_name+'\n';
                                        }
                                    }
                                }else if(header.relate_to == 'Customers#Child'){
                                    let child_data = this.data['child']
                                    for(let n = 0; n < child_data.length; n++){
                                        let child = child_data[n]
                                        if(datas[header.field_name] == child.id){
                                            clipboard_val += header.field_description + ' : '+child.customer_branch+'\n';
                                        }
                                    }
                                }
                            }else{
                                clipboard_val += header.field_description + ' : '+datas[header.field_name]+'\n';
                            }
                        }
                    }
                    if(this.table_name.status == '1'){
                        // for(let o = 0;o < this.select_status.length; o++){
                        //     let status = this.select_status[o]
                        //     if(datas.status == status.id){
                                clipboard_val += 'Status : '+datas.status_report+'\n';
                        //     }
                        // }
                    }
                }
            }
            try {
                this.execCopy(clipboard_val)
            } catch (e) {
                throw e
            }
        },

        execCopy(data){
            const tmpTextField = document.createElement("textarea")
            tmpTextField.textContent = data
            document.body.appendChild(tmpTextField)
            tmpTextField.select()
            tmpTextField.setSelectionRange(0, 99999) /*For mobile devices*/
            document.execCommand("copy")
            tmpTextField.remove()
        },

        currentDate() {
            const current = new Date();
            return current.toLocaleString();
        },

        onChangeChain(reference) {
            this.selectedSubChainIds = -1;
            if(!this.selectedChainIds) {
                this.selectedChainIds = -1;
            }
            parent = reference;
        },

        customer_change(){
            this.selectedCustomerIds = -1;
            if(!this.customerIds) {
                this.customerIds = -1;
            }
            console.log(this.customerIds)
        },

        onChangeAssign() {
            this.selectedAssign = -1;
            if(!this.assignSelector) {
                this.assignSelector = -1;
            }
        },

        sendInfo(form) {
            this.selectedUser = form;
            for(let i = 0 ; i < this.headers.length ; i++) {
                let structures = this.headers[i];
                if(structures.input_type.split('#')[0] == 'Parent') {
                    this.selectedChainIds = form[structures.field_name];
                    this.onChangeChain(structures.relate_to.split('#')[1]);
                }
                if(structures.input_type.split('#')[0] == 'Child') {
                    this.selectedSubChainIds = form[structures.field_name];
                }
                if(structures.relation == '1'){
                    this.sel[structures.field_name] = form[structures.field_name];
                    console.log(this.selected);
                }
            }
        },

        newData() {
            this.selectedChainIds = '';
            this.selectedSubChainIds = '';
            this.assignSelector = '';
            this.selectedAssign = '';
        },

        showImage() {
            return "/storage/";
        },
    },

    computed: {
        filteredChain() {
        let filteredsubChains = [];
        for(let i = 0 ; i < this.child_data.length ; i++) {
            let structures = this.child_data[i];
            if(structures.parent == this.selectedChainIds) {
                filteredsubChains.push(structures);
            }
        }
        return filteredsubChains;
        },

        filteredCustomer() {
        let filteredsubChains = [];
        let data_customer = this.data['child'];
        for(let i = 0 ; i < data_customer.length ; i++) {
            let structures = data_customer[i];
            if(structures.customer_id == this.customerIds) {
                filteredsubChains.push(structures);
            }
        }
        console.log(filteredsubChains)
        return filteredsubChains;
        },

        filteredAssign() {
        let filtered = [];
        if(this.assignSelector == 'division'){
            for(let i = 0 ; i < this.divisions.length ; i++) {
                let structures = this.divisions[i];
                filtered.push(structures);
            }
        } else if(this.assignSelector == 'user') {
            for(let i = 0 ; i < this.users.length ; i++) {
                let structures = this.users[i];
                filtered.push(structures);
            }
        }
        return filtered;
        },
    },

    setup() {
        const destroy = (id,table) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete data from table "+table,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {

                    Inertia.delete(`/apps/forms/${table}/delete_data/${id}`);

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