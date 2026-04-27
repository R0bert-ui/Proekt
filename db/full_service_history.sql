-- ПОЛНАЯ ИСТОРИЯ ОБСЛУЖИВАНИЯ ДЛЯ ВСЕХ 135 АВТОМОБИЛЕЙ

DELETE FROM `car_service`;

-- Автоматическое добавление обслуживания для каждого автомобиля
-- Используем переменные для генерации дат в зависимости от года выпуска

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'ТО-1: Замена масла и масляного фильтра',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*3) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Диагностика двигателя',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*2.5) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'ТО-2: Полное техническое обслуживание',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*2) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Замена тормозных колодок',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*1.8) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Замена воздушного фильтра',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*1.5) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Замена свечей зажигания',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*1.3) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Диагностика подвески',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Замена тормозной жидкости',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.8) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Регулировка развал-схождения',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.7) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Ремонт кондиционера',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.9) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Диагностика электрооборудования',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.6) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Замена фильтра салона',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.5) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Проверка аккумулятора',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.4) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Регулировка тормозов',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*0.3) DAY)
FROM `cars` c;

-- Дополнительные разнообразные работы для каждой машины
INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    CASE FLOOR(RAND()*8)
        WHEN 0 THEN 'Ремонт ходовой части'
        WHEN 1 THEN 'Замена пыльников'
        WHEN 2 THEN 'Ремонт кузова'
        WHEN 3 THEN 'Полировка лакокрасочного покрытия'
        WHEN 4 THEN 'Замена амортизаторов'
        WHEN 5 THEN 'Ремонт подшипников'
        WHEN 6 THEN 'Замена колодок стояночного тормоза'
        ELSE 'Обновление ПО ЭБУ'
    END,
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*2.2) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    CASE FLOOR(RAND()*7)
        WHEN 0 THEN 'ТО-1: Замена масла'
        WHEN 1 THEN 'Проверка давления в шинах'
        WHEN 2 THEN 'Ремонт стекол'
        WHEN 3 THEN 'Замена печки'
        WHEN 4 THEN 'Диагностика коробки передач'
        WHEN 5 THEN 'Чистка форсунок'
        ELSE 'Техническое обслуживание'
    END,
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*1.9) DAY)
FROM `cars` c;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    CASE FLOOR(RAND()*6)
        WHEN 0 THEN 'Замена масла в коробке передач'
        WHEN 1 THEN 'Промывка топливной системы'
        WHEN 2 THEN 'Регулировка клапанов'
        WHEN 3 THEN 'Замена охлаждающей жидкости'
        WHEN 4 THEN 'Диагностика датчиков'
        ELSE 'Профилактическое обслуживание'
    END,
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*1.6) DAY)
FROM `cars` c;

-- Добавляем еще записи для старых машин (чтобы было много истории)
INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'ТО-1: Замена масла и фильтров',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*4) DAY)
FROM `cars` c WHERE c.year <= 2020;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'ТО-2: Полное техническое обслуживание',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*3.5) DAY)
FROM `cars` c WHERE c.year <= 2020;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Диагностика двигателя',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*3) DAY)
FROM `cars` c WHERE c.year <= 2020;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Замена тормозных дисков',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*2.8) DAY)
FROM `cars` c WHERE c.year <= 2020;

INSERT INTO `car_service` (`car_id`, `service`, `date`) 
SELECT 
    c.id,
    'Ремонт подвески',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND()*365*2.5) DAY)
FROM `cars` c WHERE c.year <= 2020;

-- Обновление фотографий для всех марок
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1567818735868-e71b99932e29?auto=format&fit=crop&w=800' WHERE `brand` = 'Toyota' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800' WHERE `brand` = 'BMW' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1618652439456-1d9f53e2b1e2?auto=format&fit=crop&w=800' WHERE `brand` = 'Mercedes-Benz' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1606152421802-db97b9c7a11b?auto=format&fit=crop&w=800' WHERE `brand` = 'Audi' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1619405399517-d4af42fc2ecc?auto=format&fit=crop&w=800' WHERE `brand` = 'Kia' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=800' WHERE `brand` = 'Hyundai' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1533473359331-35b3d54fab50?auto=format&fit=crop&w=800' WHERE `brand` = 'Lexus' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?auto=format&fit=crop&w=800' WHERE `brand` = 'Volkswagen' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800' WHERE `brand` = 'Tesla' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1619405399517-d4af42fc2ecc?auto=format&fit=crop&w=800' WHERE `brand` = 'Ford' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=800' WHERE `brand` = 'Honda' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1533473359331-35b3d54fab50?auto=format&fit=crop&w=800' WHERE `brand` = 'Mazda' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?auto=format&fit=crop&w=800' WHERE `brand` = 'Nissan' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1618652439456-1d9f53e2b1e2?auto=format&fit=crop&w=800' WHERE `brand` = 'Volvo' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1569191313770-cb5bbe917ac4?auto=format&fit=crop&w=800' WHERE `brand` = 'Subaru' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800' WHERE `brand` = 'Porsche' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?auto=format&fit=crop&w=800' WHERE `brand` = 'Chevrolet' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1533473359331-35b3d54fab50?auto=format&fit=crop&w=800' WHERE `brand` = 'Jeep' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1618652439456-1d9f53e2b1e2?auto=format&fit=crop&w=800' WHERE `brand` = 'Range Rover' AND `photo_url` IS NULL;
UPDATE `cars` SET `photo_url` = 'https://images.unsplash.com/photo-1605559424843-9e4c3ca3806d?auto=format&fit=crop&w=800' WHERE `brand` = 'Jaguar' AND `photo_url` IS NULL;
