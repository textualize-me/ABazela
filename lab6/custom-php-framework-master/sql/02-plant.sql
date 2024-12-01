create table plant
(
    id      integer not null
        constraint plant_pk
            primary key autoincrement,
    subject text not null,
    content text not null
);
