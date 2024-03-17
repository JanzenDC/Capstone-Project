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
          src="../../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../../assets/favicon-128x128.png"
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
          <router-link to="/dashboard/weaver-section">
            <li class="px-[40px] mt-3">Weaver</li>
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
        <router-link to="/dashboard/supplier-restorepoint">
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

                <q-item clickable v-close-popup @click="onItemClickAll">
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
            <q-btn class="bg-[#281c0f] text-white" @click="restoreAll">
              <q-icon name="replay"/>
              Restore All
            </q-btn>
          </div>
        </div>

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
              <q-icon
                name="delete"
                class="w-[18px] h-[21px] p-1 text-white bg-red rounded"
                @click="removeRow(props.row.supplierID)"
              />
              <q-icon name="replay" class="w-[18px] h-[21px] p-1 text-white bg-[#23a393] rounded"
              @click="RestoreSupplier(props.row.supplierID)"/>

            </q-td>
          </template>
          </q-table>
        </div>

      </div>
    </div>

  </q-page>
  </template>

  <script>
  import { useQuasar } from 'quasar';
  import { SessionStorage } from 'quasar';
  import axios from 'axios';
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

        // Add DATA
        initialPagination: {
          page: 1,
          rowsPerPage: 10
        },
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
      this.statusCheckTimer = setInterval(() => {
        this.checkUserStatus();
      }, 20 * 1000); // 1 second (in milliseconds)
      this.fetchData();
    },
    beforeUnmount() {
      clearInterval(this.statusCheckTimer);
    },
    methods: {
      RestoreSupplier(supplierID){
        const targetdata = supplierID;
        const formData = {
          targetdata: targetdata,
          type: 1,
        };
        axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier_restore.php/', formData)
        .then(response => {
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
                message: `${Message}`,
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
          this.fetchData();
          console.error('Error fetching data:', error);
        });
      },
      removeRow(supplierID) {
        this.remove_action = supplierID;

        this.remove_dialog = true;
      },
      HandleRemoveDialog() {
        axios.delete(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier_restore.php/${this.remove_action}`)
        .then((response) => {
          this.remove_dialog = false;
          console.log(response.data)
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
      // Click Properties
      restoreAll(){
        console.log('clicked');
        const formData = {
          type: 2,
        };
        axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier_restore.php/', formData)
        .then(response => {
          console.log(response.data);
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "success") {
            this.$q.notify({
                message: `${Message}`,
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
          this.fetchData();
          console.error('Error fetching data:', error);
        });
      },
      onItemClickAll(){
        this.$router.push('/dashboard/supplier-section');
      },
      onItemClickDelete() {
        this.rows = [];
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=removedata`)
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
      // New Data
      fetchData(){
        this.rows = [];
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=removedata`)
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

      // Old data
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
            this.$router.push('/dashboard/supplier-restorepoint');
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
                message: 'Your account is currently inactive. Please contact the administrator.',
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
              this.$router.push('/dashboard/supplier-restorepoint');
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
