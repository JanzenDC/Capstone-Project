<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
  <div class='flex justify-between items-center text-[30px] bg-white p-2'>
    <div>
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
      <div>
        <span class="font-bold">Segregators List</span>
        <div class="text-[16px] text-[#999999]">Inventory  / <span class='text-black'>Segregators List</span></div>
      </div>
    </div>
    </div>
    <LogoutTop />
  </div>

  <div class="p-4">
    <div class="bg-white px-4 py-3 rounded h-[500px]">
        <div class="md:flex md:items-center md:justify-between ">
          <div class="grid-cols-2 grid gap-2 md:flex items-center md:gap-5">
            <q-input v-model="search" outlined dense placeholder="Search" class="md:w-[400px] ">
              <template v-slot:prepend>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
          <div class='flex gap-2'>
            <q-btn icon='download'/>
            <q-btn icon='print'/>
            <q-btn icon='cached'/>
            <q-btn icon='filter_list'/>
            <q-btn icon='add' label='Add Segregator' class="bg-[#634832] text-white" @click="addSegregator = true"/>
          </div>
        </div>

          <div class='mt-3'>
            <q-table
              class="my-sticky-header-table"
              dense bordered
              :rows="w_rows"
              :columns="w_columns"
              row-key="segregatorID"
              :selected-rows-label="getSelectedString"
              selection="multiple"
              :pagination="initialPagination"
              v-model:selected="selected"
            >
            <template v-slot:body-cell-action="props">
              <q-td :props="props">
                <div class='flex gap-2 justify-center w-[100px]'>
                  <!-- <q-btn icon='history' class='text-white bg-[#475467] w-[32px] h-[32px]'>
                    <q-tooltip :offset="[0, 8]">History</q-tooltip>
                  </q-btn> -->
                  <q-btn icon='edit' class='text-white bg-[#109CF1] w-[32px] h-[32px]' @click='editWeaver(props.row.id, props.row.name, props.row.contact, props.row.emailaddress, props.row.addresses, props.row.firstname, props.row.lastname)'>
                    <q-tooltip :offset="[0, 8]">Edit</q-tooltip>
                  </q-btn>
                  <!-- <q-btn icon='visibility' class='text-white bg-[#999999] w-[32px] h-[32px]' @click="pjoProjects(props.row.id, props.row.name)">
                    <q-tooltip :offset="[0, 8]">See Details</q-tooltip>
                  </q-btn> -->
                  <q-btn icon='delete' class='text-white bg-[#B3261E] w-[32px] h-[32px]'
                  @click='deleteWeaver(props.row.id)'>
                    <q-tooltip :offset="[0, 8]">Delete</q-tooltip>
                  </q-btn>

                </div>
              </q-td>
            </template>
            </q-table>
          </div>
    </div>
  </div>

<!-- ONSUBMIT -->
  <q-dialog v-model="addSegregator" persistent>
    <q-card class='w-[964px]'>
      <q-card-section class="row items-center q-pb-none">
        <div class='flex gap-2 items-center'>
          <q-icon name="group" class="w-[48px] h-[48px] text-h5 rounded drop-shadow-lg"/>
          <div class='text-h6'>
            Add Segregator
          </div>
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section>
        <q-form @submit="onSubmit">
            <p class='text-[16px]'>Basic Information</p>
            <div class='grid grid-cols-2 gap-2'>
                <div>
                    <label>First Name</label>
                    <q-input v-model='v_fname' dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
                </div>
                <div>
                    <label>Last Name</label>
                    <q-input v-model='v_lname' dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
                </div>
                <div>
                    <label>Contact Number</label>
                    <q-input v-model='v_contactnumber' dense outlined lazy-rules :rules="[
                        val => val && val.length === 11 && val.startsWith('09') && /^\d+$/.test(val) || 'Contact number must start with 09, be 11 digits long, and contain only numbers'
                    ]"/>
                </div>
                <div>
                    <label>Email Address</label>
                    <q-input v-model='v_emailaddress' dense outlined lazy-rules :rules="[
                        val => val && val.length > 0 && val.includes('@') || 'Please enter a valid email address'
                    ]"/>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
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
                <q-input v-model='segregatorAddress' class='hidden'/>
            </div>
            <div class='flex justify-end items-end mt-3'>
              <q-btn label="Submit" type="submit" color="primary"/>
            </div>
        </q-form>

      </q-card-section>
    </q-card>
  </q-dialog>
<!-- ONUPDATE -->
  <q-dialog v-model="editDialog" persistent>
    <q-card class='w-[964px]'>
      <q-card-section class="row items-center q-pb-none">
        <div class='flex gap-2 items-center'>
          <q-icon name="group" class="w-[48px] h-[48px] text-h5 rounded drop-shadow-lg"/>
          <div class='text-h6'>
            Edit Segregator
          </div>
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup @click='handleClose'/>
      </q-card-section>

      <q-card-section>
        <q-form @submit="onUpdate">
            <p class='text-[16px]'>Basic Information</p>
            <div class='grid grid-cols-2 gap-2'>
                <div>
                    <label>First Name</label>
                    <q-input v-model='v_fname' dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
                </div>
                <div>
                    <label>Last Name</label>
                    <q-input v-model='v_lname' dense outlined lazy-rules :rules="[ val => val && val.length > 0 || 'Please type something']"/>
                </div>
                <div>
                    <label>Contact Number</label>
                    <q-input v-model='v_contactnumber' dense outlined lazy-rules :rules="[
                        val => val && val.length === 11 && val.startsWith('09') && /^\d+$/.test(val) || 'Contact number must start with 09, be 11 digits long, and contain only numbers'
                    ]"/>
                </div>
                <div>
                    <label>Email Address</label>
                    <q-input v-model='v_emailaddress' dense outlined lazy-rules :rules="[
                        val => val && val.length > 0 && val.includes('@') || 'Please enter a valid email address'
                    ]"/>
                </div>
            </div>
            <div class='w-full'>
              <q-input v-model='segregatorAddress' dense outlined disable>
                <template v-slot:after>
                  <q-btn round dense flat icon="edit" @click="isEditing = !isEditing"/>
                </template>
              </q-input>
            </div>
            <div class="grid grid-cols-2 gap-2" :class="{ 'hidden': !isEditing }">
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
                <q-input v-model='segregatorAddress' class='hidden'/>
            </div>
            <div class='flex justify-end items-end mt-3'>
              <q-btn label="Submit" type="submit" color="primary"/>
            </div>
        </q-form>

      </q-card-section>
    </q-card>
  </q-dialog>

  <q-dialog v-model="pjoDialog" persistent>
    <q-card class='w-[964px]'>
      <q-card-section class="row items-center q-pb-none">
        <div class='flex gap-2 items-center'>
          <q-icon name="group" class="w-[48px] h-[48px] text-h5 rounded drop-shadow-lg"/>
          <div class='text-h6'>
            PJO Projects
          </div>
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup @click='handleClose'/>
      </q-card-section>

      <q-card-section>
          <div class='flex justify-between'>
            <div>
              <q-input v-model="filtersearch" label="Search..." dense outlined>
                <template v-slot:prepend>
                  <q-icon name="search" />
                </template>
              </q-input>
            </div>
            <div classs='flex '>
              <q-btn icon='download' class='ms-1 me-1'/>
              <q-btn icon='print' class='ms-1 me-1'/>
              <q-btn icon='refresh' class='ms-1 me-1'/>
              <q-btn icon='filter_list' class='ms-1 me-1'/>
            </div>
          </div>
          <q-table
            class="my-sticky-header-table mt-3"
            dense bordered
            :rows="rows_pjo"
            :columns="columns_pjo"
            row-key="pjoID"
            v-model:selected="selected"
          >
        </q-table>
      </q-card-section>

    </q-card>
  </q-dialog>
  <!-- ON DELETE -->
  <q-dialog v-model="OpenDelete">
    <q-card>
      <q-card-section class="row items-center q-pb-none">
        <div class="py-1 px-2 border text-[24px]"><q-icon name="delete"/></div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section>
        <div class="text-h6 font-bold">Delete Segregator</div>
        <p>Are you sure you want to delete this Segregator? This</p>
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
</q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import philippineData from '../../../../javascript/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';
import SideBar from '../Essentials/SideBar.vue';
import LogoutTop from '../Essentials/LogoutTop.vue';
export default {
  components: {
    SideBar,
    LogoutTop
  },
  data() {
    return {
      isAdmin: 0,
      email: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      position: '',
      status: '',
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      initialPagination: {
        page: 1,
        rowsPerPage: 10
      },
      OpenLogout: false,
      // New Data
      columns_pjo: [
        {name: 'jobOrderNo', label: 'Job Order No.', field: 'jobOrderNo', sortable: true},
        {name: 'commitmentDate', label: 'Commitment Date', field: 'commitmentDate', sortable: true},
        {name: 'size', label: 'Size', field: 'size', sortable: true},
        {name: 'total_output', label: 'Total Output', field: 'total_output', sortable: true},
        {name: 'balance', label: 'Balance', field: 'balance', sortable: true},
        {name: 'status', label: 'Status', field: 'status', sortable: true},
        {name: 'checked_by', label: 'Checked By', field: 'checked_by', sortable: true},
        {name: 'edited', label: 'Edited', field: 'edited', sortable: true},
      ],
      rows_pjo: [],
      w_columns: [
        {name: 'name', label: 'Name', field: 'name', sortable: true},
        {name: 'contact', label: 'Contact No.', field: 'contact', sortable: true},
        {name: 'emailaddress', label: 'Email Address', field: 'emailaddress', sortable: true},
        {name: 'address', label: 'Address', field: 'address', sortable: true},
        {name: 'edited', label: 'Edited', field: 'edited', sortable: true},
        {name: 'action', label: 'Action', field: 'action', sortable: true},
      ],
      w_rows: [],
      selectedRegion: null,
      selectedProvince: null,
      selectedCity: null,
      selectedBarangay: null,
      philippineData: philippineData,
      regionOptions: [],
      provinceOptions: [],
      cityOptions: [],
      barangayOptions: [],
      addSegregator: false,
      segregatorAddress: '',
      v_fname: '',
      v_lname: '',
      v_contactnumber: '',
      v_emailaddress: '',
      v_selectedID: '',
      selected: [],
      // EDIT DIALOG
      editDialog: false,
      isEditing: false,
      pjoDialog: false,
      OpenDelete: false,
      deleteget: 0,
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
  mounted() {
    this.regionOptions = Object.keys(this.philippineData)
    .map(regionCode => ({
      label: /^(0[1-9]|1[0-3]|[4][A-B]|[1-3]?[0-9])$/.test(regionCode) ? `Region ${regionCode}` : regionCode,
      value: regionCode
    }))
    .sort((a, b) => a.label.localeCompare(b.label));
    this.loadUserData();
    this.loadWeaverData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000);
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    // pjoProjects(id,name){

    //   const unitAbbreviations = {
    //     'Feet': 'ft',
    //     'Meters': 'm',
    //     'Centimeters': 'cm',
    //     'Millimeters': 'mm',
    //     'Inches': 'in'
    //   };
    //   axios.get(`http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/weaver.php?get=weaverproject&getData=${name}`)
    //   .then((response) =>{
    //     console.log(response.data)
    //     const Status = response.data.status;
    //     const Message = response.data.message;
    //     if (Status === "fail") {
    //       this.$q.notify({
    //         color: 'negative',
    //         message: `${Message}.`,
    //       });
    //     }
    //     if (Status === "success") {
    //       this.pjoDialog = true;
    //       this.rows_pjo = response.data.pjoProject.map(row => {
    //         const sizeSelectedAbbreviated = unitAbbreviations[row.size_selected] || row.size_selected;
    //         const jobOrderNoPadded = row.job_order_no.toString().padStart(3, '0');
    //         return {
    //           jobOrderNo: jobOrderNoPadded,
    //           size: row.width + 'x' + row.length + ' ' + sizeSelectedAbbreviated,
    //           total_output: row.total_output_sum,
    //           checked_by: row.checked_by
    //         };
    //       })
    //     }

    //   }).catch(error => {
    //         console.error('Error fetching data:', error);
    //   });
    // },
    editWeaver(id, name, contact, email, address, firstname, lastname) {
      this.editDialog = true;
      console.log("ID:", id);
      console.log("Name:", name);
      console.log("Contact:", contact);
      console.log("Email:", email);
      console.log("Address:", address);
      this.v_selectedID = id;
      this.v_fname = firstname;
      this.v_lname = lastname;
      this.v_contactnumber = contact;
      this.v_emailaddress = email;
      this.segregatorAddress = address;
    },
    onUpdate(){
      const formData = {
        v_selectedID: this.v_selectedID,
        segregatorAddress: this.segregatorAddress,
        v_fname: this.v_fname,
        v_lname: this.v_lname,
        v_contactnumber: this.v_contactnumber,
        v_emailaddress: this.v_emailaddress,
        type: 2,
      }
      axios.post('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php/', formData)
      .then((response) =>{
        console.log(response.data);
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: `${Message}`,
              color: 'green',
          });
          this.v_fname = '';
          this.v_lname = '';
          this.v_contactnumber = '';
          this.v_emailaddress = '';

          this.selectedProvince = null;
          this.selectedCity = null;
          this.selectedBarangay = null;
          this.editDialog = false;
          this.loadWeaverData();
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
    handleCancel(){
      this.OpenDelete = false;
      this.deleteget = null;
    },
    HandleRemove(){
      axios.delete(`http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php/${this.deleteget}`)
      .then((response) =>{
        console.log(response.data);
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: `${Message}`,
              color: 'green',
          });
          this.editDialog = false;
          this.loadWeaverData();

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
    deleteWeaver(event){
      this.OpenDelete = true;
      this.deleteget = event;
      console.log(event);

    },
    handleClose(){
        this.v_fname = '';
        this.v_lname = '';
        this.v_contactnumber = '';
        this.v_emailaddress = '';

        this.selectedProvince = null;
        this.selectedCity = null;
        this.selectedBarangay = null;
        this.addSegregator = false;
    },
    onSubmit(){
      const formData = {
        segregatorAddress: this.segregatorAddress,
        v_fname: this.v_fname,
        v_lname: this.v_lname,
        v_contactnumber: this.v_contactnumber,
        v_emailaddress: this.v_emailaddress,
        type: 1,
      }
      axios.post('http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php/', formData)
      .then((response) =>{
        console.log(response.data);
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: `${Message}`,
              color: 'green',
          });
          this.v_fname = '';
          this.v_lname = '';
          this.v_contactnumber = '';
          this.v_emailaddress = '';

          this.selectedProvince = null;
          this.selectedCity = null;
          this.selectedBarangay = null;
          this.addSegregator = false;
          this.loadWeaverData();
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
    loadWeaverData(){
      axios.get(`http://localhost/Capstone-Project/backend/api/ProductionMonitoring/Weaver_Queries/segregator.php?get=segregator`)
      .then(response => {
        console.log(response.data);
        this.w_rows = response.data.segregatorData.map(row => {
          let truncatedAddress = row.segregatorAddress.length > 15 ? row.segregatorAddress.substring(0, 15) + '...' : row.segregatorAddress;
          return {
            id: row.segregatorID,
            firstname: row.segregatorFname,
            lastname: row.segregatorLname,
            name: row.segregatorFname + ' ' + row.segregatorLname,
            contact: row.segregatorContact,
            emailaddress: row.segregatorEmail,
            address: truncatedAddress,
            addresses: row.segregatorAddress
            // edited: row.contact,
            // email: row.email,
          };
        })
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
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
          this.updateSuppAddress();
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
      this.segregatorAddress = address;
    },





    // Old Data
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleProduction(){
      this.productionVisible = !this.productionVisible;
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

        const latestAdmin = response.data.information.isAdmin;
        const latestStatus = response.data.information.status;

        if (this.status !== latestStatus || (latestAdmin && latestStatus === 0)) {
          this.status = latestStatus;

          if (this.status === 0 && !latestAdmin) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the administrator.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }
        }
    }).catch(error => {
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
        this.isAdmin = userInformation.isAdmin;
        this.fullname = this.firstname + " " + this.lastname;
        if (this.position.toLowerCase() === 'owner'  || this.position.toLowerCase() === 'production staff' || this.position.toLowerCase() === 'warehouseman') {

          this.$router.push('/dashboard/segregator-section');
        } else {

          this.$q.notify({
            type: 'negative',
            message: 'You do not have permission to access the system.',
          });
          this.$router.push('/');
          sessionStorage.clear();
        }

        if (this.status === 0 && !this.isAdmin) {
          this.$q.notify({
            type: 'negative',
            message: 'Your account is currently inactive. Please contact the administrator.',
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
