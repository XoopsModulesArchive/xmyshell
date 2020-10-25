#
# Table structure for table xmyshell_config
#

CREATE TABLE xmyshell_config (
    id         TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    selfsecure TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
    shelluser  VARCHAR(254)        NOT NULL DEFAULT '',
    shellpswd  VARCHAR(254)        NOT NULL DEFAULT '',
    dirlimit   VARCHAR(254)        NOT NULL DEFAULT '',
    errortrap  TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
    PRIMARY KEY (id)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 2;

#
# Dumping data for table xmyshell_config
#

INSERT INTO xmyshell_config (id, selfsecure, shelluser, shellpswd, dirlimit, errortrap)
VALUES (1, 1, 'admin', 'changeme', '', 1);
