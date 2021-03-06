package entity

import "time"

type Order struct {
	ID         uint64    `gorm:"primary_key:auto_increment" json:"id"`
	UserID     uint64    `gorm:"not null" json:"user_id"`
	ProductID  uint64    `gorm:"not null" json:"product_id"`
	Address    string    `gorm:"type:varchar(255)" json:"address"`
	Postcode   string    `gorm:"type:varchar(255)" json:"postcode"`
	Photo      string    `gorm:"type:text" json:"photo"`
	Status     string    `gorm:"type:varchar(255)" json:"status"`
	Resi       string    `gorm:"type:varchar(255)" json:"resi"`
	Ongkir     string    `gorm:"type:varchar(255)" json:"ongkir"`
	Total      string    `gorm:"type:varchar(255)" json:"total"`
	Notes      string    `gorm:"type:varchar(255)" json:"notes"`
	Created_at  time.Time `gorm:"type:timestamp; column:created_at; default: NOW();" json:"created_at"`
	Updated_at  time.Time `gorm:"type:timestamp; column:updated_at; default: NOW();" json:"updated_at"`
}
