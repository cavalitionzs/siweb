 <html>

 <head>
     <style {csp-style-nonce}>
         body {
             display: block;
             margin: 0;
         }

         h1 {
             margin: 0;
             background-color: whitesmoke;
             text-align: center;
         }

         img {
             display: block;
             margin: 0 auto;
             width: 15%;
             padding: 7px;
             align-items: center;
             justify-content: center;
         }

         ul {
             display: block;
             margin: 0;
             padding: 7px;
         }

         li {
             margin: 7;
             list-style-type: none;
             text-align: center;
         }

         section a {
             margin: 0;
             padding: 5px;
             margin-right: 850;
             margin-left: 850;
             display: flex;
             background-color: aquamarine;
             color: black;
             text-decoration: none;
             justify-content: center;
             align-items: center;
         }

         section a:hover {
             color: red;
             transition: .1s ease-in-out;
             transition-delay: .1s;
         }
     </style>
 </head>

 <body>
     <header>
         <div>
             <h1>Data Diri</h1>
             <img src="<?= base_url('/photo.jpg') ?>">
         </div>
     </header>

     <section>
         <div>
             <ul>
                 <li>Nama : Chandra Wijaya Kusuma</li>
                 <li>NPM : 211711038</li>
                 <li>Prodi : Sistem Informasi</li>
                 <li>Alamat : Private</li>
                 <li>Nomor Telepon</li>
                 <li>Jenis Kelamin : Laki - Laki</li>
             </ul>
         </div>
         <a href="/PO">Pengalaman Organisasi</a>
     </section>
 </body>

 </html>