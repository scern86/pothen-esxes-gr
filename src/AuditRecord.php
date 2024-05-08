<?php

namespace PothenEsxes;

class AuditRecord{

    /**
     * @param string $auditTransactionId varchar100
     * @param string $auditTransactionDate ISO 8601 timestamp with TZ
     * @param string $auditUnit varchar100
     * @param string $auditProtocol varchar100
     * @param string $auditUserId varchar100
     * @param string $auditUserIp varchar20
     */
    public function __construct(
        public string $auditTransactionId,
        public string $auditTransactionDate,
        public string $auditUnit,
        public string $auditProtocol,
        public string $auditUserId,
        public string $auditUserIp
    )
    {
    }
}