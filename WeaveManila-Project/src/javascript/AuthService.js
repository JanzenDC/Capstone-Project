// AuthService.js

import axios from 'axios';
import { SessionStorage } from 'quasar';

const AuthService = {
  information: null,

  login(email, password) {
    const formData = {
      loginEmail: email,
      loginPassword: password,
    };

    return axios.post('http://localhost/Capstone-Project/backend/api/login.php', formData)
      .then(response => {
        const status = response.data.status;
        console.log(response.data);
        if (status === 'success') {
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
          };
          SessionStorage.set('information', JSON.stringify(this.information));
          return this.information;

        } else {
          throw new Error('Invalid credentials');
        }
      });
  },

  logout() {
    // Clear information information from session storage
    SessionStorage.remove('information');
    this.information = null;
  },

  isLoggedIn() {
    // Check if information information exists in session storage
    return SessionStorage.has('information');
  },

  getUser() {
    // Retrieve information information from session storage
    return JSON.parse(SessionStorage.getItem('information'));
  },
};

export default AuthService;
