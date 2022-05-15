package dto

type OrderUpdateDTO struct {
	ID        uint64 `json:"id" binding:"required"`
	UserID    uint64 `json:"user_id" binding:"required"`
	ProductID uint64 `json:"product_id" binding:"required"`
	Address   string `json:"address" form:"address" binding:"required"`
	Postcode  string `json:"postcode" form:"postcode" binding:"required"`
	Photo     string `json:"photo" form:"photo" binding:"required"`
	Status    string `json:"status" form:"status" binding:"required"`
	Resi      string `json:"resi" form:"resi" binding:"required"`
	Ongkir    string `json:"ongkir" form:"ongkir" binding:"required"`
	Total     string `json:"total" form:"total" binding:"required"`
	Notes     string `json:"notes" form:"notes" binding:"required"`
}

type OrderCreateDTO struct {
	UserID    uint64 `json:"user_id" binding:"required"`
	ProductID uint64 `json:"product_id" binding:"required"`
	Address   string `json:"address" form:"address" binding:"required"`
	Postcode  string `json:"postcode" form:"postcode" binding:"required"`
	Photo     string `json:"photo" form:"photo" binding:"required"`
	Status    string `json:"status" form:"status" binding:"required"`
	Resi      string `json:"resi" form:"resi" `
	Ongkir    string `json:"ongkir" form:"ongkir" binding:"required"`
	Total     string `json:"total" form:"total" binding:"required"`
	Notes     string `json:"notes" form:"notes" binding:"required"`
}
