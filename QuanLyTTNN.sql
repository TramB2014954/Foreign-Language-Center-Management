create database QuanLyTTNN;
use QuanLyTTNN;
drop database QuanLyTTNN;

CREATE TABLE User_General(
	user_ID INT AUTO_INCREMENT PRIMARY KEY,
    user_Email VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    FullName varchar(100) not null,
    PhoneNumber varchar(10) unique,
    teacher_Address varchar(255),
    teacher_birthday date,
    teacher_gender varchar(6),
    teacher_nationality varchar(10),
    teacher_Specialization varchar(30),
    teacher_experience text,
    teacher_Qualification varchar(100),
    teacher_image varchar(255),
    role ENUM('manager', 'teacher', 'student') not null default 'student',
    UNIQUE KEY (user_Email)
);
select * from User_General;
update user_general set teacher_Address="30/4, phường Xuân Khánh, quận Ninh Kiều, CT", teacher_birthday='1996-2-2', teacher_gender="Nam", teacher_nationality="Kinh", 
teacher_Specialization="Tiếng Nhật", teacher_experience="2 năm làm gia sư", teacher_Qualification="N1" where user_ID=2;
update user_general set teacher_image="anhthe.jpeg" where user_ID=4;
update user_general set role="teacher" where user_ID=4;
update user_general set role="manager" where user_ID=1;
create table Type_Course (
	TC_ID char(3) primary key,
    TC_Name char(20) not null,
    TC_Combo text,
    TC_Target text,
    TC_Information text
);
select TC_ID, TC_Name from Type_Course;
drop table Type_Course;
INSERT INTO Type_Course VALUES ('001', 'PRE IELTS', '1. [IELTS Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe IELTS Listening theo phương pháp Dictation
													 |2. [IELTS Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng IELTS Reading
													 |3. [IELTS Intensive Speaking] Thực hành luyện tập IELTS Speaking
                                                     |4. [IELTS Intensive Writing] Thực hành luyện tập IELTS Writing', 
                                                     '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi IELTS Listening
                                                     |2. Luyện tập nghe hiểu các dạng recording của IELTS
                                                     |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi IELTS Reading
                                                     |4. Luyện tập phát âm, từ vựng, ngữ pháp và thực hành luyện nói các chủ đề thường gặp và forecast trong IELTS Speaking
                                                     |5. Nắm vững cách làm, cấu trúc đề thi và cách phân bổ thời gian làm bài',
                                                     '80 chủ đề, 708 bài học');
INSERT INTO Type_Course VALUES ('002', 'IELTS 4.5-5.0', '1. [IELTS Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe IELTS Listening theo phương pháp Dictation
													 |2. [IELTS Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng IELTS Reading
													 |3. [IELTS Intensive Speaking] Thực hành luyện tập IELTS Speaking
                                                     |4. [IELTS Intensive Writing] Thực hành luyện tập IELTS Writing', 
                                                     '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi IELTS Listening
                                                     |2. Luyện tập nghe hiểu các dạng recording của IELTS
                                                     |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi IELTS Reading
                                                     |4. Luyện tập phát âm, từ vựng, ngữ pháp và thực hành luyện nói các chủ đề thường gặp và forecast trong IELTS Speaking
                                                     |5. Nắm vững cách làm, cấu trúc đề thi và cách phân bổ thời gian làm bài',
                                                     '80 chủ đề, 750 bài học');
INSERT INTO Type_Course VALUES ('003', 'IELTS 5.0-5.5', '1. [IELTS Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe IELTS Listening theo phương pháp Dictation
													 |2. [IELTS Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng IELTS Reading
													 |3. [IELTS Intensive Speaking] Thực hành luyện tập IELTS Speaking
                                                     |4. [IELTS Intensive Writing] Thực hành luyện tập IELTS Writing', 
                                                     '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi IELTS Listening
                                                     |2. Luyện tập nghe hiểu các dạng recording của IELTS
                                                     |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi IELTS Reading
                                                     |4. Luyện tập phát âm, từ vựng, ngữ pháp và thực hành luyện nói các chủ đề thường gặp và forecast trong IELTS Speaking
                                                     |5. Tận dụng vốn từ đã học để tự tin giải quyết phần thi IELTS Reading một cách dễ dàng',
                                                     '83 chủ đề, 750 bài học');
INSERT INTO Type_Course VALUES ('004', 'IELTS 5.5-6.0', '1. [IELTS Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe IELTS Listening theo phương pháp Dictation
													 |2. [IELTS Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng IELTS Reading
													 |3. [IELTS Intensive Speaking] Thực hành luyện tập IELTS Speaking
                                                     |4. [IELTS Intensive Writing] Thực hành luyện tập IELTS Writing', 
                                                     '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi IELTS Listening
                                                     |2. Luyện tập nghe hiểu các dạng recording của IELTS
                                                     |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi IELTS Reading
                                                     |4. Luyện tập phát âm, từ vựng, ngữ pháp và thực hành luyện nói các chủ đề thường gặp và forecast trong IELTS Speaking
                                                     |5. Tận dụng vốn từ đã học để tự tin giải quyết phần thi IELTS Reading một cách dễ dàng',
                                                     '85 chủ đề, 760 bài học');
INSERT INTO Type_Course VALUES ('005', 'IELTS 6.0-6.5', '1. [IELTS Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe IELTS Listening theo phương pháp Dictation
													 |2. [IELTS Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng IELTS Reading
													 |3. [IELTS Intensive Speaking] Thực hành luyện tập IELTS Speaking
                                                     |4. [IELTS Intensive Writing] Thực hành luyện tập IELTS Writing', 
                                                     '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi IELTS Listening
                                                     |2. Luyện tập nghe hiểu các dạng recording của IELTS
                                                     |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi IELTS Reading
                                                     |4. Luyện tập phát âm, từ vựng, ngữ pháp và thực hành luyện nói các chủ đề thường gặp và forecast trong IELTS Speaking
                                                     |5. Tận dụng vốn từ đã học để tự tin giải quyết phần thi IELTS Reading một cách dễ dàng
                                                     |6. Nắm vững ngữ cảnh sử dụng từ vựng, phục vụ cho IELTS Writing cũng như viết luận trong môi trường học thuật',
                                                     '90 chủ đề, 800 bài học');
INSERT INTO Type_Course VALUES ('006', 'IELTS 6.5-7.0', '1. [IELTS Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe IELTS Listening theo phương pháp Dictation
													 |2. [IELTS Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng IELTS Reading
													 |3. [IELTS Intensive Speaking] Thực hành luyện tập IELTS Speaking
                                                     |4. [IELTS Intensive Writing] Thực hành luyện tập IELTS Writing', 
                                                     '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi IELTS Listening
                                                     |2. Luyện tập nghe hiểu các dạng recording của IELTS
                                                     |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi IELTS Reading
                                                     |4. Luyện tập phát âm, từ vựng, ngữ pháp và thực hành luyện nói các chủ đề thường gặp và forecast trong IELTS Speaking
                                                     |5. Tận dụng vốn từ đã học để tự tin giải quyết phần thi IELTS Reading một cách dễ dàng
                                                     |6. Nắm vững ngữ cảnh sử dụng từ vựng, phục vụ cho IELTS Writing cũng như viết luận trong môi trường học thuật',
                                                     '90 chủ đề, 820 bài học');
INSERT INTO Type_Course VALUES ('007', 'TOEIC 450+', '1. [TOEIC Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe TOEIC Listening
         |2. [TOEIC Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng TOEIC Reading',
        '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi TOEIC Listening
         |2. Luyện tập nghe hiểu các dạng recording của TOEIC
         |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi TOEIC Reading
         |4. Tận dụng vốn từ đã học để tự tin giải quyết phần thi TOEIC Reading một cách dễ dàng',
        '50 chủ đề, 450 bài học');
INSERT INTO Type_Course VALUES ('008', 'TOEIC 550+', 
        '1. [TOEIC Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe TOEIC Listening
         |2. [TOEIC Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng TOEIC Reading',
        '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi TOEIC Listening
         |2. Luyện tập nghe hiểu các dạng recording của TOEIC
         |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi TOEIC Reading
         |4. Tận dụng vốn từ đã học để tự tin giải quyết phần thi TOEIC Reading một cách dễ dàng',
        '55 chủ đề, 450 bài học');
INSERT INTO Type_Course VALUES ('009', 'TOEIC 650+', 
        '1. [TOEIC Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe TOEIC Listening
         |2. [TOEIC Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng TOEIC Reading',
        '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi TOEIC Listening
         |2. Luyện tập nghe hiểu các dạng recording của TOEIC
         |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi TOEIC Reading
         |4. Tận dụng vốn từ đã học để tự tin giải quyết phần thi TOEIC Reading một cách dễ dàng',
        '65 chủ đề, 500 bài học'); 
INSERT INTO Type_Course VALUES ('010', 'TOEIC 700+', 
        '1. [TOEIC Intensive Listening] Chiến lược làm bài - Chữa đề - Luyện nghe TOEIC Listening
         |2. [TOEIC Intensive Reading] Chiến lược làm bài - Chữa đề - Từ vựng TOEIC Reading',
        '1. Làm chủ tốc độ và các ngữ điệu khác nhau trong phần thi TOEIC Listening
         |2. Luyện tập nghe hiểu các dạng recording của TOEIC
         |3. Nắm từ vựng cơ bản xuất hiện nhiều trong phần thi TOEIC Reading
         |4. Tận dụng vốn từ đã học để tự tin giải quyết phần thi TOEIC Reading một cách dễ dàng',
        '80 chủ đề, 550 bài học');
INSERT INTO Type_Course VALUES ('011', 'Tiếng Nhật N5', 
        '1. [N5 Vocabulary] Học từ vựng tiếng Nhật cơ bản
         |2. [N5 Grammar] Học ngữ pháp tiếng Nhật cơ bản
         |3. [N5 Reading] Đọc hiểu các văn bản tiếng Nhật đơn giản
         |4. [N5 Listening] Nghe hiểu tiếng Nhật thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng tiếng Nhật cơ bản
         |2. Hiểu và sử dụng ngữ pháp tiếng Nhật cơ bản
         |3. Đọc hiểu các văn bản tiếng Nhật đơn giản
         |4. Nghe hiểu tiếng Nhật thông qua các bản ghi nghe',
        '100 từ vựng, 50 ngữ pháp, 20 đoạn văn, 10 bản ghi nghe');
INSERT INTO Type_Course VALUES ('012', 'Tiếng Nhật N4', 
        '1. [N4 Vocabulary] Học từ vựng tiếng Nhật trung cấp
         |2. [N4 Grammar] Học ngữ pháp tiếng Nhật trung cấp
         |3. [N4 Reading] Đọc hiểu các văn bản tiếng Nhật trung cấp
         |4. [N4 Listening] Nghe hiểu tiếng Nhật thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng tiếng Nhật trung cấp
         |2. Hiểu và sử dụng ngữ pháp tiếng Nhật trung cấp
         |3. Đọc hiểu các văn bản tiếng Nhật trung cấp
         |4. Nghe hiểu tiếng Nhật thông qua các bản ghi nghe',
        '150 từ vựng, 70 ngữ pháp, 30 đoạn văn, 15 bản ghi nghe');
INSERT INTO Type_Course VALUES ('013', 'Tiếng Nhật N3', 
        '1. [N3 Vocabulary] Học từ vựng tiếng Nhật nâng cao
         |2. [N3 Grammar] Học ngữ pháp tiếng Nhật nâng cao
         |3. [N3 Reading] Đọc hiểu các văn bản tiếng Nhật nâng cao
         |4. [N3 Listening] Nghe hiểu tiếng Nhật thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng tiếng Nhật nâng cao
         |2. Hiểu và sử dụng ngữ pháp tiếng Nhật nâng cao
         |3. Đọc hiểu các văn bản tiếng Nhật nâng cao
         |4. Nghe hiểu tiếng Nhật thông qua các bản ghi nghe',
        '200 từ vựng, 100 ngữ pháp, 40 đoạn văn, 20 bản ghi nghe'); 
INSERT INTO Type_Course VALUES ('014', 'New HSK 1', 
        '1. [New HSK 1 Vocabulary] Học từ vựng New HSK 1
         |2. [New HSK 1 Grammar] Học ngữ pháp New HSK 1
         |3. [New HSK 1 Reading] Đọc hiểu các văn bản New HSK 1
         |4. [New HSK 1 Listening] Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng New HSK 1
         |2. Hiểu và sử dụng ngữ pháp New HSK 1
         |3. Đọc hiểu các văn bản New HSK 1
         |4. Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '150 từ vựng, 50 ngữ pháp, 20 đoạn văn, 10 bản ghi nghe');
INSERT INTO Type_Course VALUES ('015', 'New HSK 2', 
        '1. [New HSK 2 Vocabulary] Học từ vựng New HSK 2
         |2. [New HSK 2 Grammar] Học ngữ pháp New HSK 2
         |3. [New HSK 2 Reading] Đọc hiểu các văn bản New HSK 2
         |4. [New HSK 2 Listening] Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng New HSK 2
         |2. Hiểu và sử dụng ngữ pháp New HSK 2
         |3. Đọc hiểu các văn bản New HSK 2
         |4. Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '250 từ vựng, 80 ngữ pháp, 30 đoạn văn, 15 bản ghi nghe');
INSERT INTO Type_Course VALUES ('016', 'New HSK 3', 
        '1. [New HSK 3 Vocabulary] Học từ vựng New HSK 3
         |2. [New HSK 3 Grammar] Học ngữ pháp New HSK 3
         |3. [New HSK 3 Reading] Đọc hiểu các văn bản New HSK 3
         |4. [New HSK 3 Listening] Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng New HSK 3
         |2. Hiểu và sử dụng ngữ pháp New HSK 3
         |3. Đọc hiểu các văn bản New HSK 3
         |4. Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '300 từ vựng, 100 ngữ pháp, 40 đoạn văn, 20 bản ghi nghe');
INSERT INTO Type_Course VALUES ('017', 'New HSK 4', 
        '1. [New HSK 4 Vocabulary] Học từ vựng New HSK 4
         |2. [New HSK 4 Grammar] Học ngữ pháp New HSK 4
         |3. [New HSK 4 Reading] Đọc hiểu các văn bản New HSK 4
         |4. [New HSK 4 Listening] Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng New HSK 4
         |2. Hiểu và sử dụng ngữ pháp New HSK 4
         |3. Đọc hiểu các văn bản New HSK 4
         |4. Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '400 từ vựng, 120 ngữ pháp, 50 đoạn văn, 25 bản ghi nghe');
INSERT INTO Type_Course VALUES ('018', 'New HSK 5', 
        '1. [New HSK 5 Vocabulary] Học từ vựng New HSK 5
         |2. [New HSK 5 Grammar] Học ngữ pháp New HSK 5
         |3. [New HSK 5 Reading] Đọc hiểu các văn bản New HSK 5
         |4. [New HSK 5 Listening] Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng New HSK 5
         |2. Hiểu và sử dụng ngữ pháp New HSK 5
         |3. Đọc hiểu các văn bản New HSK 5
         |4. Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '500 từ vựng, 150 ngữ pháp, 60 đoạn văn, 30 bản ghi nghe');
INSERT INTO Type_Course VALUES ('019', 'New HSK 6', 
        '1. [New HSK 6 Vocabulary] Học từ vựng New HSK 6
         |2. [New HSK 6 Grammar] Học ngữ pháp New HSK 6
         |3. [New HSK 6 Reading] Đọc hiểu các văn bản New HSK 6
         |4. [New HSK 6 Listening] Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng New HSK 6
         |2. Hiểu và sử dụng ngữ pháp New HSK 6
         |3. Đọc hiểu các văn bản New HSK 6
         |4. Nghe hiểu tiếng Trung thông qua các bản ghi nghe',
        '500 từ vựng, 150 ngữ pháp, 60 đoạn văn, 30 bản ghi nghe');
INSERT INTO Type_Course VALUES ('020', 'TOPIK 1', 
        '1. [TOPIK 1 Vocabulary] Học từ vựng TOPIK 1
         |2. [TOPIK 1 Grammar] Học ngữ pháp TOPIK 1
         |3. [TOPIK 1 Reading] Đọc hiểu các văn bản TOPIK 1
         |4. [TOPIK 1 Listening] Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng TOPIK 1
         |2. Hiểu và sử dụng ngữ pháp TOPIK 1
         |3. Đọc hiểu các văn bản TOPIK 1
         |4. Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '150 từ vựng, 50 ngữ pháp, 20 đoạn văn, 10 bản ghi nghe');
INSERT INTO Type_Course VALUES ('021', 'TOPIK 2', 
        '1. [TOPIK 2 Vocabulary] Học từ vựng TOPIK 2
         |2. [TOPIK 2 Grammar] Học ngữ pháp TOPIK 2
         |3. [TOPIK 2 Reading] Đọc hiểu các văn bản TOPIK 2
         |4. [TOPIK 2 Listening] Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng TOPIK 2
         |2. Hiểu và sử dụng ngữ pháp TOPIK 2
         |3. Đọc hiểu các văn bản TOPIK 2
         |4. Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '250 từ vựng, 80 ngữ pháp, 30 đoạn văn, 15 bản ghi nghe');
INSERT INTO Type_Course VALUES ('022', 'TOPIK 3', 
        '1. [TOPIK 3 Vocabulary] Học từ vựng TOPIK 3
         |2. [TOPIK 3 Grammar] Học ngữ pháp TOPIK 3
         |3. [TOPIK 3 Reading] Đọc hiểu các văn bản TOPIK 3
         |4. [TOPIK 3 Listening] Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng TOPIK 3
         |2. Hiểu và sử dụng ngữ pháp TOPIK 3
         |3. Đọc hiểu các văn bản TOPIK 3
         |4. Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '300 từ vựng, 100 ngữ pháp, 40 đoạn văn, 20 bản ghi nghe');
INSERT INTO Type_Course VALUES ('023', 'TOPIK 4', 
        '1. [TOPIK 4 Vocabulary] Học từ vựng TOPIK 4
         |2. [TOPIK 4 Grammar] Học ngữ pháp TOPIK 4
         |3. [TOPIK 4 Reading] Đọc hiểu các văn bản TOPIK 4
         |4. [TOPIK 4 Listening] Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '1. Nắm vững từ vựng TOPIK 4
         |2. Hiểu và sử dụng ngữ pháp TOPIK 4
         |3. Đọc hiểu các văn bản TOPIK 4
         |4. Nghe hiểu tiếng Hàn thông qua các bản ghi nghe',
        '400 từ vựng, 120 ngữ pháp, 50 đoạn văn, 25 bản ghi nghe');
        
create table Day_Of_Week(
	Day_ID int primary key,
	Day_Of_Week varchar(20)
);
select * from Day_Of_Week;
drop table Day_Of_Week;
INSERT INTO Day_Of_Week VALUES (2, 'Thứ 2');
INSERT INTO Day_Of_Week VALUES (3, 'Thứ 3');
INSERT INTO Day_Of_Week VALUES (4, 'Thứ 4');
INSERT INTO Day_Of_Week VALUES (5, 'Thứ 5');
INSERT INTO Day_Of_Week VALUES (6, 'Thứ 6');
INSERT INTO Day_Of_Week VALUES (7, 'Thứ 7');
INSERT INTO Day_Of_Week VALUES (8, 'Chủ Nhật');

create table Class_Session(
	Class_ID int primary key,
    Class_Time varchar(10)
);
select * from Class_Session;
drop table Class_Session;
INSERT INTO Class_Session VALUES (1, '7h-8h30');
INSERT INTO Class_Session VALUES (2, '9h-10h30');
INSERT INTO Class_Session VALUES (3, '13h30-15h');
INSERT INTO Class_Session VALUES (4, '17h30-19h');
INSERT INTO Class_Session VALUES (5, '19h30-21h');
        
create table Course(
	course_ID int auto_increment primary key,
    course_Name varchar(50) not null,
    Class_Name varchar(20) not null,
    course_Fee decimal not null,
    course_TotalSlot int not null,
    course_AvailableSlot int,
    StartDate date,
    EndDate date,
    TC_ID char(3),
    Class_ID int,
    foreign key (Class_ID) references Class_Session(Class_ID),
    foreign key (TC_ID) references Type_Course(TC_ID) on delete cascade on update cascade,
    unique key (Class_Name)
);
select * from Course;
drop table Course;
update course set course_availableSlot =0 where course_ID=1;
create table Class_Day(
	course_ID int,
    Day_ID int,
    primary key (course_ID, Day_ID),
    foreign key (course_ID) references Course(course_ID),
    foreign key (Day_ID) references Day_Of_Week(Day_ID)
);
select * from Class_Day;
drop table Class_Day;

create table Student_Registration(
	user_ID INT,
    course_ID int,
    registration_date datetime,
    primary key(user_ID, course_ID),
    foreign key (course_ID) references Course(course_ID) on delete cascade on update cascade,
    foreign key (user_ID) references User_General(user_ID) on delete cascade on update cascade
);
select * from Student_Registration; 
drop table Student_Registration;
INSERT INTO Student_Registration VALUES ('3', 'C0001', NOW());
DELETE FROM Student_Registration WHERE user_ID = '3' AND course_ID = 'C0005';

create table Teacher_Registration(
	registration_id INT AUTO_INCREMENT PRIMARY KEY,
	user_ID int,
    course_ID int,
    registration_date datetime,
    status enum('pending', 'approved', 'rejected' ) not null default 'pending',
    foreign key (course_ID) references Course(course_ID) on delete cascade on update cascade,
    foreign key (user_ID) references User_General(user_ID) on delete cascade on update cascade
);
select * from Teacher_Registration where user_id=5;
delete from teacher_registration where registration_id=8;

drop table teacher_registration;
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (1, 1, now());
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (3, 1, now());
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (1, 2, now());
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (2, 3, now());
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (3, 2, now());
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (1, 4, now());
insert into Teacher_Registration(user_ID, course_ID, registration_date) values (2, 4, now());

SELECT  * FROM teacher_Registration r
                JOIN Course c ON r.course_ID = c.course_ID
                where r.status = 'approved';
SELECT c.*
FROM Course c
LEFT JOIN Teacher_Registration tr ON c.course_ID = tr.course_ID
WHERE tr.registration_id IS NULL OR tr.status IN ('pending', 'rejected');


create table Notice(
	notice_id INT AUTO_INCREMENT PRIMARY KEY,
    notice_status int default 1 CHECK (notice_status BETWEEN 0 AND 1),
    registration_id int
);
select * from Notice;
drop table notice;




select * from class_day where day_id = 3 or day_id=5 or day_id=7;

select c.course_id, cd.day_id, t.user_id from student_registration t
join course c on c.course_id = t.course_id
join class_day cd on c.course_id = cd.course_id
 where t.user_id=4 and (cd.day_id = 3 or cd.day_id=5 or cd.day_id=7);

select c.course_id, cs.Class_id, cs.class_Time, t.user_id from student_registration t
join course c on c.course_id = t.course_id
join class_session cs on c.class_id = cs.class_id
 where t.user_id=4;
 
SELECT c.course_id, cd.day_id, t.user_id from Student_Registration t
                                join course c on c.course_id = t.course_id
                                join class_day cd on c.course_id = cd.course_id
                                WHERE t.user_ID = (SELECT user_ID FROM User_General WHERE user_Email = 'student@gmail.com') 
                                and (cd.day_id = 3 or cd.day_id = 5 or cd.day_id = 7);
                                
SELECT c.course_id, cs.Class_id, cs.class_Time, t.user_id from Student_Registration t
                                    join course c on c.course_id = t.course_id
                                    join class_session cs on c.class_id = cs.class_id
                                    where  t.user_ID = (SELECT user_ID FROM User_General WHERE user_Email = 'student@gmail.com') and cs.class_id = 1 ;