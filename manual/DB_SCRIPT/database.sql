-- 初始化数据库，并插入一条超级管理员数据，密码为123456，加密后插入数据库。
CREATE DATABASE if not exists DB_ams default character SET utf8 collate utf8_general_ci;

USE DB_ams;

CREATE TABLE if not exists AMS_user(
    id int(11) unsigned not null auto_increment comment '用户ID,自增主键',
    uid varchar(128) not null default '' comment '用户标识ID',
    username varchar(20) binary not null default '' comment '登录帐号',
    userpwd varchar(255) binary not null default '' comment '登陆密码,加密存储',
    nick_name varchar(50) not null default '' comment '用户昵称',
    privilege_code varchar(100) not null default '' comment '用户权限，默认所有用户有查询权限。out-in-admin，表示用户拥有出库，入库和超级管理员权限',
    wid tinyint(3) unsigned not null default 0 comment '用户可操作的仓库ID',
    is_enabled tinyint(1) unsigned not null default 0 comment '帐号状态，0禁用，1启用',
    last_time int(11) unsigned not null default 0 comment '最后登录时间',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(id)
)engine=innodb default charset=utf8 comment='用户信息表';

CREATE TABLE if not exists AMS_category(
    cid int(11) unsigned not null auto_increment comment '分类id,自增主键',
    category_name varchar(50) not null default '' comment '分类显示名称',
    pid int(11) unsigned not null default 0 comment '记录父分类ID',
    wid tinyint(3) unsigned not null default 0 comment '仓库id,对应warehouse表中的wid',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(cid)
)engine=innodb default charset=utf8 comment='分类信息表';

CREATE TABLE if not exists AMS_goods(
    gid int(11) unsigned not null auto_increment comment '物品id,自增主键',
    goods_name varchar(50) not null default '' comment '物品名称',
    cid int(11) unsigned not null default 0 comment '分类编号，对应category 表中的cid',
    wid tinyint(3) unsigned not null default 0 comment '仓库id,对应warehouse表中的wid',
    bid tinyint(3) unsigned not null default 0 comment '储物柜id,对应box表中的bid',
    sid tinyint(3) unsigned not null default 0 comment '供应商id,对应supplier表中的sid',
    check_status tinyint(1) unsigned not null default 0 comment '盘点状态，1正在盘点，0盘点结束',
    goods_count int(11) unsigned not null default 0 comment '物品库存数量',
    note varchar(255) not null default '' comment '备注栏',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(gid)
)engine=innodb default charset=utf8 comment='物品信息表';

CREATE TABLE if not exists AMS_box(
    bid tinyint(3) unsigned not null auto_increment comment '储物箱ID，自增主键',
    box_name varchar(50) not null default '' comment '储物箱名称',
    wid tinyint(3) unsigned not null default 0 comment '仓库id,对应warehouse表中的wid',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(bid)
)engine=innodb default charset=utf8 comment='储物箱信息表';

CREATE TABLE if not exists AMS_warehouse(
	wid tinyint(3) unsigned not null auto_increment comment '仓库id,自增主键',
    warehouse_name varchar(50) not null default '' comment '仓库名称',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key (wid)
)engine = InnoDB default charset  = utf8 comment='仓库信息表';

CREATE TABLE if not exists AMS_outstock(
	id int(11) unsigned not null auto_increment comment '记录id,自增主键',
    gid int(11) unsigned not null default 0 comment '对应物品信息表gid字段',
    goods_sn varchar(50) not null default '' comment '物品SN编码',
    out_count int(11) unsigned not null default 0 comment '出库数量',
    consumer_code varchar(20) not null default '' comment '用户工号',
	typeid int(11) unsigned not null default 0 comment '电脑型号ID,对应computer表中的typeid',
    computer_sn varchar(50) not null default '' comment '电脑SN编码',
    computer_barcode varchar(50) not null default '' comment '电脑资产条码',
    record_time int(11) unsigned not null default 0 comment '记录操作时间',
    nick_name varchar(50) not null default '' comment '当前操作人，对应用户信息表nick_name字段',
    note varchar(255) not null default '' comment '备注栏',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(id)
)engine=innodb default charset=utf8 comment='出库记录表';

CREATE TABLE if not exists AMS_instock(
	id int(11) unsigned not null auto_increment comment '记录id,自增主键',
	gid int(11) unsigned not null default 0 comment '对应物品信息表gid字段',
    in_count int(11) unsigned not null default 0 comment '入库数量',
    record_time int(11) unsigned not null default 0 comment '记录操作时间',
    nick_name varchar(50) not null default '' comment '当前操作人，对应用户信息表nick_name字段',
    note varchar(255) not null default '' comment '备注栏',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(id)
)engine=innodb default charset=utf8 comment='入库记录表';

CREATE TABLE if not exists AMS_checkstock(
	id int(11) unsigned not null auto_increment comment '自增主键',
    gid int(11) unsigned not null default 0 comment '对应物品信息表gid字段',
    stock_count int(11) unsigned not null default 0 comment '物品库存数量',
    check_count int(11) unsigned not null default 0 comment '本次盘点的实物数量',
    check_time int(11) unsigned not null default 0 comment '盘点开始时间',
    notes varchar(255) not null default '' comment '记录库存盘点数量有异常时的说明',
    nick_name varchar(50) not null default '' comment '当前操作人，对应用户信息表nick_name字段',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(id)
)engine=innodb default charset=utf8 comment='库存盘点表';

CREATE TABLE if not exists AMS_supplier(
    sid tinyint(3) unsigned not null auto_increment comment '供应商ID，主键自增',
    supplier_name varchar(50) not null default '' comment '供应商名称',
    wid tinyint(3) unsigned not null default 0 comment '仓库id,对应warehouse表中的wid',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(sid)
)engine=innodb default charset=utf8 comment='供应商信息表';

CREATE TABLE if not exists AMS_privilege(
    id tinyint(3) unsigned not null auto_increment comment '权限ID，主键自增',
    privilege_code varchar(100) not null default '' comment '权限编码, out = 出库, in = 入库, admin = 超级管理员',
    privilege_name varchar(50) not null default '' comment '权限名称, 出库，入库，超级管理员',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(id)
)engine=innodb default charset=utf8 comment='权限信息表';

CREATE TABLE IF NOT EXISTS 	AMS_computer(
	typeid int(11) unsigned not null auto_increment comment '自增主键',
    type_name varchar(50) not null default '' comment '电脑型号',
    wid tinyint(3) unsigned not null default 0 comment '仓库id,对应warehouse表中的wid',
    is_deleted tinyint(1) unsigned not null default 0 comment '删除状态，0未删除，1已删除',
    primary key(typeid)
)engine=innodb default charset=utf8 comment='电脑型号列表';

INSERT INTO AMS_user(uid, username, userpwd, nick_name, privilege_code, is_enabled)
            VALUES(md5('admin123456'), 'admin', '$2y$10$t/aSQKeBaUc4KU.vLafCDOZdNcqgIojoPj2VRygYhqaRvHe5cvO6u', '超级管理员', 'out-in-admin', 1);
