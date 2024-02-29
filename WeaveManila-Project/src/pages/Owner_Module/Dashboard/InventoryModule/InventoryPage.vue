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

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
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
<q-page class="bg-[#f5f5f5] ">
  <div class="text-[30px] bg-white p-2">
    <div class="items-center flex ">
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
    <span class="font-bold">Inventory</span>
    </div>
    <div class="text-[16px]">Efficiently manage and track your stock for streamlined supply chain operations and optimized inventory.</div>
  </div>
  <div class="p-4">
    <div class="flex md:items-end md:justify-end mt-6 ">
      <div class="flex items-center gap-5">
        <q-input v-model="search" outlined dense placeholder="Search" class="md:w-[400px]">
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>
        <q-btn @click="addCategory = true" class="bg-[#281c0f] text-white">
          <i class="bi bi-plus-lg"></i>
          Add Category
        </q-btn>
      </div>
    </div>

    <q-dialog v-model="addCategory">
        <q-card>
          <q-form @submit="onSubmit">
          <q-card-section class="row items-center q-pb-none">
            <div class="text-h6 font-bold">Add Category</div>
            <q-space />
            <q-btn icon="close" flat round dense v-close-popup />
          </q-card-section>

          <q-card-section class="scroll">
            <label>
              Category Name<span class="text-red-600">*</span>
            </label>
            <q-input type="text" label="Category Name" v-model="title"  outlined dense :rules="[val => !!val || 'Field is required']"/>
              <label>
                Procedure<span class="text-red-600">*</span>
              </label>
              <q-select
                outlined dense
                v-model="selectedProcedure"
                :options="procedureOptions"
                label="Select Procedure"
                :rules="[val => !!val || 'Field is required']"
              />
            <label class="">
              Item Description<span class="text-red-600">*</span>
            </label>
            <q-input
              type="textarea"
              label="Item Description"
              v-model="description"
              outlined
              dense
              :rules="[val => !!val || 'Field is required']"
              style="width: 300px; resize: none;"
            />
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

    <q-dialog v-model="OpenDelete">
        <q-card>
          <q-card-section class="row items-center q-pb-none">
            <div class="py-1 px-2 border text-[24px]"><q-icon name="delete"/></div>
            <q-space />
            <q-btn icon="close" flat round dense v-close-popup />
          </q-card-section>

          <q-card-section>
            <div class="text-h6 font-bold">Delete Card</div>
            <p>Are you sure you want to delete this card? This</p>
            <p>action cannot be undone.</p>
          </q-card-section>

          <q-card-actions class="flex justify-center items-center">
            <div class="w-1/2 p-1">
              <q-btn flat label="Cancel" outline v-close-popup class="w-full border"/>
            </div>
            <div class="w-1/2 p-1">
              <q-btn
                @click="onDelete"
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

      <div class="max-[390px]:mt-3 md:grid md:grid-cols-4 gap-4 md:p-4 h-[435px] overflow-y-auto overflow-x-hidden" >
      <!-- Display fetched data in the grid with checkboxes -->
      <div v-for="item in filteredItems" :key="item.id" style="border: #b09582 2px solid " class=" min-[390px]:mt-3 relative min-[390px]:w-full md:w-[231px] bg-white drop-shadow-lg border-[#b09582] rounded ">
        <q-card flat>
          <q-card-section>
            <div class="row items-center no-wrap">
              <div class="col">
                <div class="text-h6">{{ item.title }}</div>
              </div>
              <div class="col-auto">
                <q-btn color="grey-7" round flat icon="more_vert">
                  <q-menu cover auto-close>
                    <q-list>
                      <q-item clickable @click="handleViewClick(item)">
                        <q-item-section>View Details</q-item-section>
                      </q-item>
                      <q-item clickable @click="handleEditClick(item)">
                        <q-item-section>Edit Card</q-item-section>
                      </q-item>
                      <q-item clickable @click="handleDeleteClick(item)">
                        <q-item-section>Delete Card</q-item-section>
                      </q-item>
                    </q-list>
                  </q-menu>
                </q-btn>
              </div>
            </div>
          </q-card-section>

          <q-card-section>
            <div class="items-center flex gap-3">
              <q-icon name="inventory_2" class="text-[#b09582]"/>
              <div class="grid grid-cols-2 gap-4">
                <p>Inventory</p>
                {{ getItemCount(item.categoryID) }}
              </div>
            </div>
            <div class="flex items-center gap-2">
              <q-icon name="short_text" class="text-[#b09582]"/>
              <p>Description:</p>
              <p class="overflow-hidden whitespace-nowrap overflow-ellipsis w-[86px]">{{ item.description }}asd adasdas</p>
            </div>



          </q-card-section>
        </q-card>
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
      search: '',
      title: '',
      description: '',
      items: [],
      countData: {},
      selectedItems: [],
      isOptionsOpen: {},
      selectedProcedure: null,
      procedureOptions: ["Process & issuance", "Issuance only"],

      OpenDelete: false,
      targetDelete: '',

    };
  },
  computed: {
    filteredItems() {
      // Filter items based on the search input
      return this.items.filter(item => {
        const lowerSearch = this.search.toLowerCase();
        return item.title.toLowerCase().includes(lowerSearch) || item.description.toLowerCase().includes(lowerSearch);
      });
    },
  },
  mounted() {
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchData();
    this.clearInventoryData();
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    clearInventoryData() {
      sessionStorage.removeItem('inventoryData');
    },
    onSubmit(){
      const formData = {
        title: this.title,
        procedure: this.selectedProcedure,
        description: this.description,

      }
      axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php/', formData)
      .then(response => {

        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Category Added!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.title = '';
          this.description = '';
          this.procedureOptions = [];
          this.addCategory = false;
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
    fetchData() {

      axios.get('http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type=1')
        .then(response => {
          if (response.data && response.data.status === 'success' && response.data.information) {
            const fetchedData = response.data.information.rows;
            const countData = response.data.information.itemCountData;
            this.countData = countData;
            this.items = fetchedData;
          } else {
            console.error('Failed to fetch data:', response.data.message);
          }
        })
        .catch(error => {
          // Handle any errors that occur during the HTTP request
          console.error('Error fetching data:', error.message);
        });
    },
    toggleOptions(itemId) {
      // Close dropdown for other items
      Object.keys(this.isOptionsOpen).forEach(id => {
        if (id !== itemId) {
          this.isOptionsOpen[id] = false;
        }
      });

      // Toggle the dropdown options for the clicked item
      this.isOptionsOpen[itemId] = !this.isOptionsOpen[itemId];
    },
    getItemCount(categoryID) {
      return this.countData[categoryID] || 0;
    },
    handleViewClick(itemId) {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type&id=${itemId.categoryID}`)
      .then(response => {

        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          const inventoryData = {
            InventoryId: itemId.categoryID,
            InventoryName: itemId.title,
          }
          SessionStorage.set('inventoryData', JSON.stringify(inventoryData));
          this.$router.push('/dashboard/inventory-viewpage');
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
    handleEditClick(itemId) {
      console.log('Edit button clicked for item ID:', itemId.categoryID);
    },
    handleDeleteClick(itemId) {
      this.targetDelete = itemId.categoryID;
      this.OpenDelete = true;
    },

// Execution
    onDelete(){
      axios.delete(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php/${this.targetDelete}`)
      .then(response => {
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Category deleted successfully!!',
              color: 'green',
          });
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
        }
        this.OpenDelete = false;
        this.fetchData();
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
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
          this.$router.push('/dashboard/inventory-section');
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
          if (this.position.toLowerCase() === 'owner') {
            this.$router.push('/dashboard/inventory-section');
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

