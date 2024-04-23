<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
  <div class='flex justify-between items-center text-[30px] bg-white p-2'>
    <div class="">
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
    <LogoutTop />
  </div>

  <div class="p-4">

      <div class="flex mt-3">
        <router-link to="inventory-section">
          <div class="flex bg-white w-[135px] border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="library_books"/>
            <p>Details</p>
          </div>
        </router-link>
        <router-link to="segregator-section">
          <div class="flex w-[135px] text-[#89909e] border-t-2 border-l-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[12px]">
              <q-icon name="list"/>
              <p>Segregator</p>
            </div>
        </router-link>
      </div>
    <div class="p-4 overflow-y-auto overflow-x-hidden h-[400px] bg-white">
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
  </div>
</q-page>
<q-dialog v-model="OpenLogout">
  <q-card class="w-[500px]">
    <q-card-section class="gap-3 items-center q-pb-none flex">
      <div class="py-1 px-2 border text-[24px]"><q-icon name="logout"/></div>
      <div class="text-h6 font-bold">Logout</div>
      <q-space />
    </q-card-section>

    <q-card-section>

      <p>Are you sure you want to Logout?</p>
    </q-card-section>

    <q-card-actions class="flex justify-center items-center">
      <div class="w-1/2 p-1">
        <q-btn flat label="Cancel" outline v-close-popup class="w-full border"/>
      </div>
      <div class="w-1/2 p-1">
        <q-btn
          @click="logout"
          flat
          label="Logout"
          size="md"
          class="bg-red-600 text-white rounded w-full"
        />
      </div>
    </q-card-actions>
  </q-card>
</q-dialog>

</template>

<script>
import { useQuasar } from 'quasar';
import { SessionStorage } from 'quasar';
import axios from 'axios';
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
      addCategory: false,
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      OpenLogout: false,
      // Add DATA
      search: '',
      title: '',
      description: '',
      items: [],
      countData: {},
      selectedItems: [],
      isOptionsOpen: {},
      selectedProcedure: null,
      procedureOptions: ["Segregate & issuance", "Issuance only"],

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
            suffix: information.suffix,
            civil_status: information.civil_status
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
          if (this.position.toLowerCase() === 'owner') {

            this.$router.push('/dashboard/inventory-section');
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
