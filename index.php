<?php
require(__DIR__ . '/setup.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tugas 3</title>

   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-gray-900 text-gray-300">

   <div id="app">
      <!-- NAVBAR -->
      <nav class="top-0 left-0 w-full bg-gray-800 p-4 flex justify-center">
         <div class="flex items-center">
            <img src="images/logout.png" class="w-20 mr-2" alt="Logo">
            <div>
               <div class="text-lg font-semibold">Database Mahasiswa UT</div>
               <div class="text-sm">Tugas 3 - MSIM4309</div>
            </div>
         </div>
      </nav>
      <!-- END NAVBAR -->

      <!-- CONTENT -->
      <div class="pt-10 max-w-3xl mx-auto">
         <!-- PENCARIAN DAN TOMBOL TAMBAH -->
         <div class="flex justify-between items-center mb-4">
            <input type="text" v-model="search" class="w-2/3 p-2 bg-gray-800 text-gray-300 border border-gray-700 rounded" placeholder="Cari berdasarkan Nama / NIM">
            <button @click="openModal('create')" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Mahasiswa</button>
         </div>

         <!-- TABEL -->
         <ul>
            <li v-for="mhs in filteredMahasiswa" :key="mhs.id" class="bg-gray-900 p-4 mb-2 rounded shadow hover:bg-gray-700 transition duration-300">
               <h2 class="text-xl font-semibold mb-2">{{ mhs.nama }}</h2>
               <table class="w-full text-sm mb-2">
                  <tr>
                     <td class="font-semibold">NIM</td>
                     <td>: {{ mhs.nim }}</td>
                  </tr>
                  <tr>
                     <td class="font-semibold">Info Lahir</td>
                     <td>: {{ mhs.tempat_lahir }}, {{ mhs.tanggal_lahir_format }} ({{ mhs.umur }} Tahun)</td>
                  </tr>
                  <tr>
                     <td class="font-semibold">Jenis Kelamin</td>
                     <td>: {{ mhs.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                  </tr>
                  <tr>
                     <td class="font-semibold">Alamat</td>
                     <td>: {{ mhs.alamat }}</td>
                  </tr>
                  <tr>
                     <td class="font-semibold">E-Mail</td>
                     <td>: {{ mhs.email }}</td>
                  </tr>
                  <tr>
                     <td class="font-semibold">No. Telp</td>
                     <td>: {{ mhs.no_telp }}</td>
                  </tr>
                  <tr>
                     <td class="font-semibold">Tahun Masuk Ajaran</td>
                     <td>: {{ mhs.tahun_masuk }}</td>
                  </tr>
               </table>
               <div class="flex justify-end gap-2">
                  <button @click="openModal('update', mhs)" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                  <button @click="openModal('delete', mhs)" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
               </div>
            </li>
         </ul>
      </div>
      <!-- END CONTENT -->

      <!-- MODAL -->
      <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
         <div class="bg-gray-800 p-6 rounded shadow-lg w-96">
            <h2 class="text-2xl mb-4">{{ modalTitle }}</h2>
            <form @submit.prevent="handleSubmit">
               <div class="mb-4" v-if="modalType !== 'delete'">
                  <label class="block mb-2">Nama</label>
                  <input type="text" v-model="form.nama" class="w-full p-2 bg-gray-700 text-gray-300 border border-gray-600 rounded">
               </div>
               <div class="mb-4" v-if="modalType !== 'delete'">
                  <label class="block mb-2">NIM</label>
                  <input type="text" v-model="form.nim" class="w-full p-2 bg-gray-700 text-gray-300 border border-gray-600 rounded">
               </div>
               <div class="flex justify-end gap-2 mt-4">
                  <button @click="closeModal" type="button" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                  <button v-if="modalType !== 'delete'" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                  <button v-if="modalType === 'delete'" @click="handleDelete" type="button" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
               </div>
            </form>
         </div>
      </div>
      <!-- END MODAL -->
   </div>

   <script>
      const app = Vue.createApp({
         data() {
            return {
               mahasiswa: [],
               search: '',
               isModalOpen: false,
               modalType: '',
               modalTitle: '',
               form: {
                  id: '',
                  nama: '',
                  nim: '',
               }
            }
         },
         computed: {
            filteredMahasiswa() {
               return this.mahasiswa.filter(mhs => {
                  return mhs.nama.toLowerCase().includes(this.search.toLowerCase()) || mhs.nim.toLowerCase().includes(this.search.toLowerCase())
               })
            }
         },
         methods: {
            openModal(type, mhs = {}) {
               this.modalType = type;
               this.isModalOpen = true;
               this.form = {
                  ...mhs
               };

               if (type === 'create') {
                  this.modalTitle = 'Tambah Mahasiswa';
               } else if (type === 'update') {
                  this.modalTitle = 'Edit Mahasiswa';
               } else if (type === 'delete') {
                  this.modalTitle = 'Hapus Mahasiswa';
               }
            },
            closeModal() {
               this.isModalOpen = false;
               this.form = {};
            },
            handleSubmit() {
               if (this.modalType === 'create') {
                  // Handle create
                  fetch('create.php', {
                        method: 'POST',
                        headers: {
                           'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                     })
                     .then(response => response.json())
                     .then(data => {
                        this.mahasiswa.push(data);
                        this.closeModal();
                     });
               } else if (this.modalType === 'update') {
                  // Handle update
                  fetch('update.php', {
                        method: 'POST',
                        headers: {
                           'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                     })
                     .then(() => {
                        const index = this.mahasiswa.findIndex(mhs => mhs.id === this.form.id);
                        this.$set(this.mahasiswa, index, {
                           ...this.form
                        });
                        this.closeModal();
                     });
               }
            },
            handleDelete() {
               // Handle delete
               fetch('delete.php', {
                     method: 'POST',
                     headers: {
                        'Content-Type': 'application/json'
                     },
                     body: JSON.stringify({
                        id: this.form.id
                     })
                  })
                  .then(() => {
                     this.mahasiswa = this.mahasiswa.filter(mhs => mhs.id !== this.form.id);
                     this.closeModal();
                  });
            }
         },
         mounted() {
            fetch('fetch.php')
               .then(response => response.json())
               .then(data => {
                  this.mahasiswa = data.map(mhs => {
                     mhs.birthDate = moment(mhs.tanggal_lahir);
                     mhs.tanggal_lahir_format = mhs.birthDate.locale('id').format('DD MMMM YYYY');
                     mhs.umur = moment().diff(mhs.birthDate, 'years');
                     return mhs;
                  });
               });
         }
      });

      app.mount('#app');
   </script>
</body>

</html>