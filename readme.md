# Test Indo Prima Gemilang
Test Code

## 🚀 RUN Project
```shell
php -S localhost:8000
```

## 💫 SQL
```sql
CREATE DATABASE LAWANCOVID;

USE LAWANCOVID;

CREATE TABLE DEPARTMENT (
    IDDept INT AUTO_INCREMENT PRIMARY KEY,
    Nama_Dept VARCHAR(15) UNIQUE
);

CREATE TABLE KARYAWAN (
    IDKaryawan INT AUTO_INCREMENT PRIMARY KEY,
    Nama VARCHAR(30),
    NoKTP VARCHAR(20) UNIQUE,
    Telp VARCHAR(20),
    Kota_Tinggal VARCHAR(20),
    Tanggal_lahir DATE,
    Tanggal_Masuk DATE,
    Department INT,
    Kota_Penempatan VARCHAR(20),
    FOREIGN KEY (Department) REFERENCES DEPARTMENT(IDDept)
);

-- Insert dummy records for DEPARTMENT
INSERT INTO DEPARTMENT (Nama_Dept) VALUES
    ('Accounting'),
    ('Marketing'),
    ('Produksi');

-- Insert dummy records for KARYAWAN
INSERT INTO KARYAWAN (Nama, NoKTP, Telp, Kota_Tinggal, Tanggal_lahir, Tanggal_Masuk, Department, Kota_Penempatan) VALUES
    ('Budi', '1234567890123456', '08123456789', 'Surabaya', '1980-01-01', '2020-01-01', 1, 'Surabaya'),
    ('David', '6543210987654321', '08567890123', 'Surabaya', '1995-06-15', '2021-06-15', 2, 'Surabaya'),
    ('Fajar', '1111222233334444', '08765432100', 'Nganjuk', '2000-02-20', '2022-02-20', 3, 'Nganjuk');
```

```sql


-- Insert dummy records for DEPARTMENT
INSERT INTO DEPARTMENT (Nama_Dept) VALUES
    ('Accounting'),
    ('Marketing'),
    ('Produksi'),
    ('IT'),
    ('HR');

-- Insert dummy records for KARYAWAN
INSERT INTO KARYAWAN (Nama, NoKTP, Telp, Kota_Tinggal, Tanggal_lahir, Tanggal_Masuk, Department, Kota_Penempatan) VALUES
    ('John Doe', '1234567890', '123456789', 'Surabaya', '1990-01-15', '2020-01-01', 1, 'Surabaya'),
    ('Jane Doe', '9876543210', '987654321', 'Jakarta', '1995-05-20', '2021-02-15', 2, 'Jakarta'),
    ('Bob Smith', '5555555555', '555555555', 'Bandung', '1988-08-10', '2019-10-05', 3, 'Bandung'),
    ('Alice Johnson', '1111222233', '111122223', 'Yogyakarta', '1992-11-30', '2022-03-20', 4, 'Yogyakarta'),
    ('Eva Williams', '4444333322', '444433332', 'Surabaya', '1997-04-25', '2021-12-10', 5, 'Surabaya');
```

## 😎 Development by
[![Findryankp](https://img.shields.io/badge/Findryankp-grey?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Findryankp)
[![findryankp](https://img.shields.io/badge/findryankp-blue?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/Findryankp/)
