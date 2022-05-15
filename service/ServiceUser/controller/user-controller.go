package controller

import (
	"fmt"
	"net/http"
	"strconv"

	"github.com/dgrijalva/jwt-go"
	"github.com/gin-gonic/gin"
	"github.com/rickyananda1/golang_gin_gorm_JWT/dto"
	"github.com/rickyananda1/golang_gin_gorm_JWT/helper"
	"github.com/rickyananda1/golang_gin_gorm_JWT/service"
)

type UserController interface {
	Update(context *gin.Context)
	Profile(context *gin.Context)
}

type userController struct {
	userService service.UserService
	jwtService  service.JWTService
}

func NewUserController(userService service.UserService, jwtService service.JWTService) UserController {
	return &userController{
		userService: userService,
		jwtService:  jwtService,
	}
}

func (c *userController) Update(context *gin.Context) {
	var userUpdateDTO dto.UserUpdateDTO
	errDTO := context.ShouldBind(&userUpdateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		context.AbortWithStatusJSON(http.StatusBadRequest, res)
		return
	}
	authHeader := context.GetHeader("Authorization")
	token, errToken := c.jwtService.ValidateToken(authHeader)
	if errToken != nil {
		panic(errToken.Error())
	}
	claims := token.Claims.(jwt.MapClaims)
	id, err := strconv.ParseUint(fmt.Sprintf("%v", claims["user_id"]), 10, 64)
	if err != nil {
		panic(err.Error())
	}
	userUpdateDTO.ID = id
	u := c.userService.Update(userUpdateDTO)
	res := helper.BuildResponse(true, "OK!", u)
	context.JSON(http.StatusOK, res)
}

func (c *userController) Profile(context *gin.Context) {
	authHeader := context.GetHeader("Authorization")
	token, errToken := c.jwtService.ValidateToken(authHeader)
	if errToken != nil {
		response := helper.BuildErrorResponse("Failed to process request", errToken.Error(), helper.EmptyObj{})
		context.AbortWithStatusJSON(http.StatusUnauthorized, response)
		return
	}

	claims := token.Claims.(jwt.MapClaims)
	id, errClaims := strconv.ParseUint(fmt.Sprintf("%v", claims["user_id"]), 10, 64)
	if errClaims != nil {
		response := helper.BuildErrorResponse("Failed to process request", errClaims.Error(), helper.EmptyObj{})
		context.AbortWithStatusJSON(http.StatusUnauthorized, response)
		return
	}
	idString := strconv.FormatUint(id, 10)
	user := c.userService.Profile(idString)
	res := helper.BuildResponse(true, "User profile retrieved successfully", user)
	context.JSON(http.StatusOK, res)
}
