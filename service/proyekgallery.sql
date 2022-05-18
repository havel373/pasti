/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : PostgreSQL
 Source Server Version : 120007
 Source Host           : localhost:5432
 Source Catalog        : proyekgallery
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 120007
 File Encoding         : 65001

 Date: 15/05/2022 23:18:17
*/


-- ----------------------------
-- Sequence structure for galleries_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."galleries_id_seq";
CREATE SEQUENCE "public"."galleries_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS "public"."galleries";
CREATE TABLE "public"."galleries" (
  "id" int8 NOT NULL GENERATED ALWAYS AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
),
  "nama" varchar(255) COLLATE "pg_catalog"."default",
  "nim" varchar(255) COLLATE "pg_catalog"."default",
  "email" varchar(255) COLLATE "pg_catalog"."default",
  "photo" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of galleries
-- ----------------------------
INSERT INTO "public"."galleries" OVERRIDING SYSTEM VALUE VALUES (2, 'Tesa', '11320012', 'tesa@gmail.com', 'image.jpeg');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."galleries_id_seq"
OWNED BY "public"."galleries"."id";
SELECT setval('"public"."galleries_id_seq"', 3, true);

-- ----------------------------
-- Primary Key structure for table galleries
-- ----------------------------
ALTER TABLE "public"."galleries" ADD CONSTRAINT "galleries_pkey" PRIMARY KEY ("id");
