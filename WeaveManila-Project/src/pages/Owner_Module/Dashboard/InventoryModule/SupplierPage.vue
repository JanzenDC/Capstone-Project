<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="drawerWidth">
  <ul class=" p-2 flex flex-col h-full static" v-if="drawerWidth !== 80">
    <div class="flex">
      <div class="w-1/4 items-center flex justify-center" >
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
      <div class="text-[#281c0f] text-[18px] w-3/4 flex justify-center items-center gap-1" v-if="drawerWidth !== 80">
      <div>
        <span class="font-bold ">WEAVEMANILA INC.</span><br>
      </div>
      <div>
        <q-icon name="keyboard_double_arrow_right" class="text-[30px] cursor-pointer" @click="toggleDrawer" />
      </div>
    </div>

    </div>



    <li class="font-bold mt-5">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2" /> <span >Dashboard</span>
          </router-link>
        </div>
      </li>

      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> <span >Inventory</span></div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <router-link to="/dashboard/inventory-section">
            <li class="py-[2px] px-[40px] mt-3">Materials</li>
          </router-link>
          <router-link to="/dashboard/mpoform-section">
            <li class="px-[40px] mt-3"> Material Purchase Order</li>
          </router-link>
        </ul>
      </li>

      <li class="py-[10px] px-[20px]" @click="toggleProduction">
        <div class="flex items-center gap-2 justify-between">
          <div>
            <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
          </div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="productionVisible">
          <router-link to="/dashboard/productionplan-section">
            <li class="py-[2px] px-[40px] mt-3">Production Plan</li>
          </router-link>
          <router-link to="/dashboard/joborder-section">
            <li class="px-[40px] mt-3">Job Order</li>
          </router-link>
        </ul>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="assignment_add" class="mr-2"/><span>Report</span>
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold" >Admin</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/auditlogs-section">
            <i class="bi bi-activity mr-2"></i> <span >Audit Logs</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/usermanagement-section">
            <q-icon name="group" class="mr-2"/> <span >User Management</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/account-settings">
            <q-icon name="manage_accounts" class="mr-2"/> <span >Account Settings</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]" v-if="isAdmin === 1">
        <div class="flex items-center">
          <router-link to="/dashboard/backup-section">
            <q-icon name="backup" class="mr-2"/> <span >Data Backup</span>
          </router-link>
        </div>
      </li>

      <li class="mt-auto py-[10px]">
        <q-separator />
        <div class="flex justify-between text-center" >
          <div class="flex items-center" >
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-12 md:w-12 rounded-full"
            />
            <div class="ml-2 overflow-hidden">
              <div class="whitespace-nowrap overflow-hidden text-overflow-ellipsis font-bold">
                {{ getLimitedFullname(fullname, 25) }}
              </div>
              <div class="text-center">
                {{ position }}
              </div>
            </div>
          </div>
          <div class="flex items-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
        </div>
      </li>
  </ul>

  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth <= 80">

    <div class="flex justify-center items-center text-[40px]">
      <div class=" items-center flex justify-center cursor-pointer" v-if="drawerWidth <= 80">
        <q-icon name="keyboard_double_arrow_right" @click="toggleDrawer"/>
      </div>
    </div>

      <li class="mt-5 text-center">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="dashboard" />
        </div>
      </li>
      <!-- Process Section -->

      <li class="py-[10px] px-[20px]" @click="toggleDrawer">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/></div>
        </div>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2" @click="toggleDrawer">
          <i class="bi bi-box-seam"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="description" />
        </div>
      </li>
      <li class="text-center">Admin</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <i class="bi bi-activity"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="group" class="mr-2"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="manage_accounts"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="backup"/>
        </div>
      </li>

      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
      </li>
  </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5]">
  <div class="text-[30px] bg-white p-2">
    <div class="items-center flex">
      <q-icon
        name="menu"
        v-if="showMenuIcon"
        @click="toggleDrawer"
        class="cursor-pointer"
      />
      <q-icon
        name="menu"
        v-if="!showMenuIcon"
        @click="toggleDrawer"
        class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
      />
    <span class="font-bold ">Supplier List</span>
    </div>
    <div class="text-[16px]"><span class="text-[#b8b8b8]">Inventory / </span>Supplier List</div>
  </div>


  <div class="p-4">
    <div class="flex mt-3">
      <router-link to="/dashboard/mpoform-section">
        <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-l-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="note_add"/>
          <p>MPO Form</p>
        </div>
      </router-link>
      <router-link to="/dashboard/mpo-section">
        <div class="flex  w-[155px] text-[#b8b8b8] border-l-2 border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="list"/>
          <p>Purchase list</p>
        </div>
      </router-link>
      <router-link to="/dashboard/supplier-section">
        <div class="flex w-[155px] bg-white h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="group"/>
            <p>Supplier List</p>
          </div>
      </router-link>
    </div>
    <div class="bg-white px-4 py-3">

      <div class="md:flex md:items-center md:justify-between ">
        <div class="grid-cols-2 grid gap-2 md:flex items-center md:gap-5">
          <q-input v-model="search" outlined dense placeholder="Search" class="md:w-[400px] ">
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
        <div class="flex items-center gap-2">
          <q-btn v-if="selected.length > 0" @click="handleDeleteClick" class="bg-red-600 text-white">
            <q-icon name="delete"/>
            Remove
          </q-btn>
          <q-btn-dropdown icon="filter_alt" label="Filter">
            <q-list>
              <q-item clickable v-close-popup>
                <q-item-section>
                  <q-item-label>Active</q-item-label>
                </q-item-section>
              </q-item>

              <q-item clickable v-close-popup>
                <q-item-section>
                  <q-item-label>All</q-item-label>
                </q-item-section>
              </q-item>

              <q-item clickable v-close-popup @click="onItemClickDelete">
                <q-item-section>
                  <q-item-label>Delete</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
          <q-btn @click="AddSupplier" class="bg-[#281c0f] text-white">
            <i class="bi bi-plus-lg"></i>
            Add Supplier
          </q-btn>
        </div>
      </div>

  <!-- Add supplier Modal -->
      <q-dialog v-model="addSupplier">
          <q-card class="w-[904px]">
            <q-form @submit="onSubmit">
            <q-card-section class="row items-center q-pb-none">

              <div class="text-h6 font-bold flex items-center gap-2">
                <q-icon name="group" class="p-2 border"/>
                Add Supplier
              </div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />
            </q-card-section>

            <q-card-section >
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <label> <!--Supplier Name-->
                    Supplier Name<span class="text-red-600">*</span>
                  </label>
                  <q-input type="text" label="Supplier Name" v-model="suppName" required lazy-rules :no-error-icon="true" outlined dense :rules="[val => !!val || 'Field is required']"/>
                </div>
                <div>
                  <label>
                    Email<span class="text-red-600">*</span>
                  </label>
                <q-input
                    type="email"
                    label="Email"
                    v-model="suppEmail"
                    :no-error-icon="true"
                    outlined
                    dense
                    lazy-rules
                    required
                    :rules="[ruleEmail]"
                  />

                </div>
                <div>
                  <label>
                    Contact Person<span class="text-red-600">*</span>
                  </label>
                  <q-input type="text" label="Contact Person" v-model="suppContactName" required lazy-rules :no-error-icon="true" outlined dense :rules="[val => !!val || 'Field is required']"/>
                </div>
                <div>
                  <label>
                    Contact Number<span class="text-red-600">*</span>
                  </label>
                  <q-input type="tel" label="Contact Number" v-model="suppCp" lazy-rules required :no-error-icon="true" outlined dense :rules="[val => !!val || 'Phone Number is required', val => /^09\d{9}$/g.test(val) || 'Invalid Phone Number']"/>
                </div>
              </div>
              <label> <!--Supplier Address-->
                Supplier Address<span class="text-red-600">*</span>
              </label>
              <q-input type="text" label="Supplier Address" v-model="suppAddress" required lazy-rules :no-error-icon="true" class="w-full" outlined dense :rules="[val => !!val || 'Field is required']" @click="onSupplierAddressClick" />
            </q-card-section>
            <q-separator />

            <q-card-actions align="right">
              <q-btn flat label="Cancel" color="primary" v-close-popup />
              <q-btn
                flat
                label="Save"
                type="submit"
                icon="save"
                size="md"
                class="bg-[#281c0f] text-white rounded"
              />
            </q-card-actions>
          </q-form>
          </q-card>
      </q-dialog>

<!-- Supplier Menu Address -->
      <q-dialog v-model="supplierAddress">
              <q-card class="w-[904px]">
                <q-card-section class="row items-center q-pb-none">
                  <div class="text-h6 font-bold flex items-center gap-2">
                    <q-icon name="location_on" class="p-2 border"/>
                    Supplier Address
                  </div>
                  <q-space />

                </q-card-section>

                <q-card-section >
                  <div class="">
                      <div>
                        <label>Region<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedRegion" :options="regionOptions" label="Region" @input="onRegionChange" dense outlined class='flex-wrap' />
                      </div>
                      <div>
                        <label>Province<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedProvince" :options="provinceOptions" label="Province" dense outlined :disable="!selectedRegion" class='flex-wrap'/>
                      </div>
                      <div>
                        <label>City<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedCity" :options="cityOptions" label="City" dense outlined :disable="!selectedProvince" class='flex-wrap'/>
                      </div>
                      <div>
                        <label>Barangay<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedBarangay" :options="barangayOptions" label="Barangay" dense outlined :disable="!selectedCity" />
                      </div>
                  </div>
                </q-card-section>
                <q-separator />

                <q-card-actions align="right">
                  <q-btn
                    flat
                    label="Save"
                    color="primary"
                    @click="SupplierSave"
                    :disable="!selectedRegion || !selectedProvince || !selectedCity || !selectedBarangay"
                  />
                </q-card-actions>

              </q-card>
      </q-dialog>

<!-- Delete/Remove Dialog Modal -->
      <q-dialog v-model="OpenDelete">
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="py-1 px-2 border text-[24px]"><q-icon name="delete"/></div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />
            </q-card-section>

            <q-card-section>
              <div class="text-h6 font-bold">Delete Supplier</div>
              <p>Are you sure you want to delete this supplier? This</p>
              <p>action cannot be undone.</p>
            </q-card-section>

            <q-card-actions class="flex justify-center items-center">
              <div class="w-1/2 p-1">
                <q-btn flat label="Cancel" outline v-close-popup class="w-full border" @click="handleCancel"/>
              </div>
              <div class="w-1/2 p-1">
                <q-btn
                  @click="HandleRemove"
                  flat
                  label="Delete"
                  type="submit"
                  size="md"
                  class="bg-red-600 text-white rounded w-full"
                />
              </div>
            </q-card-actions>
          </q-card>
      </q-dialog>
<!-- Delete/Remove 1 selectedDialog Modal -->
      <q-dialog v-model="remove_dialog">
          <q-card>
            <q-card-section class="row items-center q-pb-none">
              <div class="py-1 px-2 border text-[24px]"><q-icon name="delete"/></div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />
            </q-card-section>

            <q-card-section>
              <div class="text-h6 font-bold">Delete Supplier</div>
              <p>Are you sure you want to delete this supplier? This</p>
              <p>action cannot be undone.</p>
            </q-card-section>

            <q-card-actions class="flex justify-center items-center">
              <div class="w-1/2 p-1">
                <q-btn flat label="Cancel" outline v-close-popup class="w-full border" @click="handleCancel"/>
              </div>
              <div class="w-1/2 p-1">
                <q-btn
                  @click="HandleRemoveDialog"
                  flat
                  label="Delete"
                  type="submit"
                  size="md"
                  class="bg-red-600 text-white rounded w-full"
                />
              </div>
            </q-card-actions>
          </q-card>
      </q-dialog>

      <div class="py-5">
        <q-table
          class="my-sticky-header-table"
          flat bordered
          :rows="filteredTableData"
          :columns="columns"
          row-key="supplierID"
          :selected-rows-label="getSelectedString"
          selection="multiple"
          :pagination="initialPagination"
          v-model:selected="selected"
        >
        <template v-slot:body-cell-selection="props">
          <q-td :props="props">
            <q-checkbox
              v-model="props.selected"
              :val="props.row.supplierID"
              @input="handleCheckboxChange(props.row.supplierID)"
            />
          </q-td>
        </template>

        <template v-slot:body-cell-actions="props">
          <q-td :props="props" class="text-center flex gap-2">
            <q-icon name="edit_square" class="w-[18px] h-[21px] p-1 text-white bg-blue-500 rounded"
            @click="EditSupplier(props.row.supplierID, props.row.supplier,props.row.contact_person,props.row.contact,props.row.address,props.row.email)"/>
            <q-icon
              name="delete"
              class="w-[18px] h-[21px] p-1 text-white bg-red rounded"
              @click="removeRow(props.row.supplierID)"
            />
          </q-td>
        </template>
        </q-table>
      </div>


<!-- OnUpdate -->
      <q-dialog v-model="showDropdown">
          <q-card class="w-[904px]">
            <q-form @submit="onUpdate">
            <q-card-section class="row items-center q-pb-none">

              <div class="text-h6 font-bold flex items-center gap-2">
                <q-icon name="group" class="p-2 border"/>
                Add Supplier
              </div>
              <q-space />
              <q-btn icon="close" flat round dense v-close-popup />
            </q-card-section>

            <q-card-section >
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <label> <!--Supplier Name-->
                    Supplier Name<span class="text-red-600">*</span>
                  </label>
                  <q-input type="text" label="Supplier Name" v-model="suppName" required lazy-rules :no-error-icon="true" outlined dense :rules="[val => !!val || 'Field is required']"/>
                </div>
                <div>
                  <label>
                  Email<span class="text-red-600">*</span>
                </label>
                <q-input
                    type="email"
                    label="Email"
                    v-model="suppEmail"
                    :no-error-icon="true"
                    outlined
                    dense
                    lazy-rules
                    required
                    :rules="[ruleEmail]"
                  />

                </div>
                <div>
                  <label>
                    Contact Person<span class="text-red-600">*</span>
                  </label>
                  <q-input type="text" label="Contact Person" v-model="suppContactName" required lazy-rules :no-error-icon="true" outlined dense :rules="[val => !!val || 'Field is required']"/>
                </div>
                <div>
                <label>
                  Contact Number<span class="text-red-600">*</span>
                </label>
                <q-input type="tel" label="Contact Number" v-model="suppCp" lazy-rules required :no-error-icon="true" outlined dense :rules="[val => !!val || 'Phone Number is required', val => /^09\d{9}$/g.test(val) || 'Invalid Phone Number']"/>
                </div>
              </div>
              <label> <!--Supplier Address-->
                Supplier Address<span class="text-red-600">*</span>
              </label>
              <q-input type="text" label="Supplier Address" v-model="suppAddress" required lazy-rules :no-error-icon="true" class="w-full" outlined dense :rules="[val => !!val || 'Field is required']" @click="EditsupplierAddress = true"/>
            </q-card-section>

            <q-separator />

            <q-card-actions align="right">
              <q-btn flat label="Cancel" color="primary" @click="handleCancelEdit" v-close-popup />
              <q-btn
                flat
                label="Save"
                type="submit"
                icon="save"
                size="md"
                class="bg-[#281c0f] text-white rounded"
              />
            </q-card-actions>
          </q-form>
          </q-card>
      </q-dialog>
  <!-- Supplier Menu Address -->
      <q-dialog v-model="EditsupplierAddress">
              <q-card class="w-[904px]">
                <q-card-section class="row items-center q-pb-none">
                  <div class="text-h6 font-bold flex items-center gap-2">
                    <q-icon name="location_on" class="p-2 border"/>
                    Supplier Address
                  </div>
                  <q-space />

                </q-card-section>

                <q-card-section >
                  <div class="">
                      <div>
                        <label>Region<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedRegion" :options="regionOptions" label="Region" @input="onRegionChange" dense outlined class='flex-wrap' />
                      </div>
                      <div>
                        <label>Province<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedProvince" :options="provinceOptions" label="Province" dense outlined :disable="!selectedRegion" class='flex-wrap'/>
                      </div>
                      <div>
                        <label>City<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedCity" :options="cityOptions" label="City" dense outlined :disable="!selectedProvince" class='flex-wrap'/>
                      </div>
                      <div>
                        <label>Barangay<span class="text-red-600">*</span></label>
                        <q-select v-model="selectedBarangay" :options="barangayOptions" label="Barangay" dense outlined :disable="!selectedCity" />
                      </div>
                  </div>
                </q-card-section>
                <q-separator />

                <q-card-actions align="right">
                  <q-btn
                    flat
                    label="Save"
                    color="primary"
                    @click="supplierUpdateSave"
                    :disable="!selectedRegion || !selectedProvince || !selectedCity || !selectedBarangay"
                  />
                </q-card-actions>

              </q-card>
      </q-dialog>

    </div>
  </div>

</q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import philippineData from '../../../../javascript/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';

export default {
  setup() {
      const $q = useQuasar();
  },
  data() {
    return {
      isAdmin: 0,
      id: '',
      email: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      position: '',
      status: '',
      addCategory: false,
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      // Add DATA
      initialPagination: {
        page: 1,
        rowsPerPage: 10
      },
      addSupplier: false,
      columns : [
      {name: 'supplier', label: 'Supplier', field: 'supplier', sortable: true},
      {name: 'contact_person', label: 'Contact Person', field: 'contact_person', sortable: true},
      {name: 'address', label: 'Address', field: 'address', sortable: true},
      {name: 'contact', label: 'Contact', field: 'contact', sortable: true},
      {name: 'email', label: 'Email', field: 'email', sortable: true},
      {name: 'actions', label: 'Actions', field: 'actions', sortable: true, align: 'center'},
    ],
    rows : [],
    selected: [],
    remove_action: '',
    remove_dialog: false,
    search: '',
    OpenDelete: false,
    // Supplier Data
    selectedSupp: '',
    suppName: '',
    suppAddress: '',
    suppContactName: '',
    suppCp: '',
    suppEmail: '',
    showDropdown: false,
    // supplierAddress Dialogs
    EditsupplierAddress: false,
    supplierAddress: false,
    // Location Data
      selectedRegion: null,
      selectedProvince: null,
      selectedCity: null,
      selectedBarangay: null,
      philippineData: philippineData,
      regionOptions: [],
      provinceOptions: [],
      cityOptions: [],
      barangayOptions: []
    };
  },
  watch: {
    selectedRegion: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onRegionChange();
      }
    },
    selectedProvince: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onProvinceChange();
      }
    },
    selectedCity: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onCityChange();
      }
    },
    selectedBarangay: function(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.onBaranggayChange();
      }
    }
  },
  computed: {
    filteredTableData() {
    const searchQuery = this.search.toLowerCase();
      return this.rows.filter(row =>
        row.supplier.toLowerCase().includes(searchQuery) ||
        row.contact_person.toLowerCase().includes(searchQuery) ||
        row.email.toLowerCase().includes(searchQuery)
      );
    },
  },
  mounted() {
    this.loadUserData();
    console.log(this.philippineData);
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchData();
    this.regionOptions = Object.keys(this.philippineData)
    .map(regionCode => ({
      label: /^(0[1-9]|1[0-3]|[4][A-B]|[1-3]?[0-9])$/.test(regionCode) ? `Region ${regionCode}` : regionCode,
      value: regionCode
    }))
    .sort((a, b) => a.label.localeCompare(b.label));
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    AddSupplier(){
      this.selectedSupp = '';
      this.suppName = '';
      this.suppAddress = '';
      this.suppContactName = '';
      this.suppCp = '';
      this.suppEmail = '';
      this.selectedRegion = null;
      this.selectedProvince = null;
      this.selectedCity = null;
      this.selectedBarangay = null;
      this.addSupplier = true;
    },
    supplierUpdateSave(){
      this.EditsupplierAddress = false;
      this.showDropdown = true;
    },
    SupplierSave(){
      this.supplierAddress = false;
      this.addSupplier = true;
    },
    onSupplierAddressClick(){
      this.supplierAddress = true;
      this.addSupplier = false;
    },
    onRegionChange() {
    //   console.log(this.selectedRegion.value);
    //   console.log(philippineData[this.selectedRegion.value]);
    //  // Access the province list for the selected region
      this.selectedProvince = null;
      this.selectedCity = null;
      this.selectedBarangay = null;
      const regionData = this.philippineData[this.selectedRegion.value].province_list;

      // Map the province names to options format
      this.provinceOptions = Object.keys(regionData).map(provinceName => ({
        label: provinceName,
        value: provinceName
      }));
      this.updateSuppAddress();
    },
    onProvinceChange() {
      // Check if selectedProvince is not null before accessing its value
      if (this.selectedProvince !== null) {
        this.selectedCity = null;
        this.selectedBarangay = null;
        const selectedProvinceData = this.philippineData[this.selectedRegion.value].province_list[this.selectedProvince.value];
        if (selectedProvinceData) {
          const municipalityData = selectedProvinceData.municipality_list;
          console.log(municipalityData);

          this.cityOptions = Object.keys(municipalityData).map(municipalityName => ({
            label: municipalityName,
            value: municipalityName
          }));
        }
      }
    },
    onCityChange() {
      if (this.selectedCity !== null) {
        this.selectedBarangay = null;
        const selectedMunicipalityData = this.philippineData[this.selectedRegion.value].province_list[this.selectedProvince.value].municipality_list[this.selectedCity.value];
        if (selectedMunicipalityData) {
          const barangayList = selectedMunicipalityData.barangay_list;
          console.log(barangayList);

          this.barangayOptions = barangayList.map(barangayName => ({
            label: barangayName,
            value: barangayName
          }));
          this.updateSuppAddress();
        }
      }
    },
    onBaranggayChange() {
      if (this.selectedBarangay !== null) {
        this.updateSuppAddress();
      }
    },
    updateSuppAddress() {

      let address = '';
      if (this.selectedRegion) address += `${this.selectedRegion.label}, `;
      if (this.selectedProvince) address += `${this.selectedProvince.label}, `;
      if (this.selectedCity) address += `${this.selectedCity.label}, `;
      if (this.selectedBarangay) address += `${this.selectedBarangay.label}`;
      this.suppAddress = address;
    },


    EditSupplier(targetID, supplier_name, contact_person,contact, address, email) {
      this.showDropdown = true;
      this.selectedSupp = targetID;
      this.suppName = supplier_name;
      this.suppAddress = address;
      this.suppContactName = contact_person;
      this.suppCp = contact;
      this.suppEmail = email;
    },
    handleCancelEdit() {
      this.showDropdown = false;
      this.selectedSupp = '';
      this.suppName = '';
      this.suppAddress = '';
      this.suppContactName = '';
      this.suppCp = '';
      this.suppEmail = '';
    },
    removeRow(supplierID) {
      this.remove_action = supplierID;

      this.remove_dialog = true;
    },
    HandleRemoveDialog() {
      console.log(this.remove_action);
      axios.delete(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier_selected.php/${this.remove_action}`)
      .then((response) => {
        this.remove_dialog = false;

        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Supplier Removed!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.fetchData();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
        }
      }).catch(error => {
        console.error('Error fetching data:', error);
      });

      this.selected = [];
    },
    onItemClickDelete() {
      this.$router.push('/dashboard/supplier-restorepoint');
    },
    // New Data
    fetchData(){
      this.rows = [];
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=alldata`)
      .then(response => {
        this.rows = response.data.information.values.map(row => {
          return {
            supplierID: row.supplierID,
            supplier: row.supplier_name,
            contact_person: row.contact_person,
            address: row.address,
            contact: row.contact,
            email: row.email,
          };
        })
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
    },
    handleCheckboxChange(rowId) {
      const index = this.selected.indexOf(rowId);

      if (index === -1) {
        this.selected.push(rowId);
      } else {
        this.selected.splice(index, 1);
      }

    },
    getSelectedString() {
      return `Selected ${this.selected.length} item(s)`;
    },
    extractSelectedIds() {
      return this.selected.map(item => item.supplierID);
    },
    // Removing Data
    handleCancel(){
      this.selected = [];
    },
    handleDeleteClick() {
      this.OpenDelete = true;
    },
    HandleRemove() {
      const selectedIds = this.extractSelectedIds();
      axios.delete(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php/${this.id}`, {
        data: { selectedIds: selectedIds },
      }).then((response) => {
        this.OpenDelete = false;
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Supplier Removed!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.fetchData();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
        }
      }).catch(error => {
        console.error('Error fetching data:', error);
      });

      this.selected = [];
    },
    // Adding Data
    onSubmit() {
        const formData = {
          supplier_Name: this.suppName,
          supplier_Address: this.suppAddress,
          supplier_ContactName: this.suppContactName,
          supplier_Cp: this.suppCp,
          supplier_Email: this.suppEmail,
        }
        axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php/', formData)
        .then(response => {
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
                message: 'Supplier Added!!',
                caption: `${Message}`,
                color: 'green',
            });
            this.suppName = '';
            this.suppAddress = '';
            this.suppContactName = '';
            this.suppCp = '';
            this.suppEmail = '';
            this.addSupplier = false;
            this.fetchData();
          }
          if (Status === "fail") {
            this.$q.notify({
              color: 'negative',
              message: `${Message} Please try again.`,
            });
          }
        }).catch(error => {
          console.error('Error fetching data:', error);
      });
    },
    ruleEmail(value) {
      // Basic email validation using a regular expression
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(value) || 'Please enter a valid email address';
    },
    // Updating Data
    onUpdate() {
        const formData = {
          supplier_Name: this.suppName,
          supplier_Address: this.suppAddress,
          supplier_ContactName: this.suppContactName,
          supplier_Cp: this.suppCp,
          supplier_Email: this.suppEmail,
        }
        axios.put(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php/${this.selectedSupp}/`, formData)
        .then(response => {
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
                message: 'Supplier has been update!!',
                caption: `${Message}`,
                color: 'green',
            });
            this.suppName = '';
            this.suppAddress = '';
            this.suppContactName = '';
            this.suppCp = '';
            this.suppEmail = '';
            this.addSupplier = false;
            this.fetchData();
          }
          if (Status === "fail") {
            this.$q.notify({
              color: 'negative',
              message: `${Message} Please try again.`,
            });
          }
        }).catch(error => {
          console.error('Error fetching data:', error);
      });
    },

    // Old data
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleDrawer() {
      if (!this.toggleDrawers) {
        this.drawer = true;
        this.drawerWidth = 300;
        this.drawerIcon = 'arrow_forward_ios';
        this.toggleDrawers = true;
      } else {
        this.drawer = true;
        this.drawerWidth = 80;
        this.toggleDrawers = false;
        this.drawerIcon = 'arrow_back_ios_new';
      }
    },
    checkUserStatus() {
        axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
        .then(response => {
        const latestStatus = response.data.information.status;
        const information = response.data.information;
          this.information = {
            id: information.id,
            email: information.email,
            username: information.username,
            pfp: information.pfp,
            firstname: information.firstname,
            middlename: information.middlename,
            lastname: information.lastname,
            gender: information.gender,
            position: information.position,
            mobilenumber: information.mobilenumber,
            birthdate: information.birthdate,
            age: information.age,
            address: information.address,
            otp_code: information.otp_code,
            isOnline: information.isOnline,
            status: information.status,
            password: information.password,
            isAdmin: information.isAdmin,
          };
          SessionStorage.set('information', JSON.stringify(this.information));
        const Position = response.data.information.position;
        if (Position.toLowerCase() === 'owner') {
          this.$router.push('/dashboard/supplier-section');
        }else{
          this.$q.notify({
          type: 'negative',
            message: 'You do not have permission to access the system.',
          });
          this.$router.push('/');
          sessionStorage.clear();
        }
        if (this.status !== latestStatus) {
          this.status = latestStatus;

          if (this.status === 0) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
        }
      }).catch(error => {
        this.$router.push('/');
        sessionStorage.clear();
        console.error('Error fetching data:', error);
      });
    },
    loadUserData() {
      const userData = SessionStorage.getItem('information');
      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.status = userInformation.status;
          this.id = userInformation.id;
          this.isAdmin = userInformation.isAdmin;

          this.fullname = this.firstname + " " + this.lastname;
          if (this.position.toLowerCase() === 'owner') {
            this.$router.push('/dashboard/supplier-section');
          }else{
            this.$q.notify({
            type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
          if(this.status == 0)
          {
            this.$q.notify({
            type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/');
          sessionStorage.clear();
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/');
        sessionStorage.clear();
      }
    },
    getLimitedFullname(fullname, maxLength) {
      if (fullname.length > maxLength) {
        return fullname.substring(0, maxLength) + '...';
      }
      return fullname;
    },
    getUserProfileImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.userProfileImage) {
        return `/pfp/${this.userProfileImage}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
      }
    },
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>

<style lang="sass">
.my-sticky-header-table
  /* height or max-height is important */
  height: 330px

  .q-table__top,

  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #fff
    text-align: center
    font-size: 13px

  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0

  /* this is when the loading indicator appears */
  &.q-table--loading thead tr:last-child th
    /* height of all previous header rows */
    top: 48px

  /* prevent scrolling behind sticky top row on focus */
  tbody
    /* height of all previous header rows */
    scroll-margin-top: 48px

</style>
