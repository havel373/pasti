package service

import (
	"log"

	"github.com/mashingan/smapping"
	"github.com/rickyananda1/golang_gin_gorm_JWT/dto"
	"github.com/rickyananda1/golang_gin_gorm_JWT/entity"
	"github.com/rickyananda1/golang_gin_gorm_JWT/repository"
)

type UserService interface {
	Update(user dto.UserUpdateDTO) entity.User
	All() []entity.User
	Profile(userID string) entity.User
}

type userService struct {
	userRepository repository.UserRepository
}

func NewUserService(userRepo repository.UserRepository) UserService {
	return &userService{
		userRepository: userRepo,
	}
}

func (service *userService) Update(user dto.UserUpdateDTO) entity.User {
	userToUpdate := entity.User{}
	err := smapping.FillStruct(&userToUpdate, smapping.MapFields(&user))
	if err != nil {
		log.Fatalf("Failed map %v:", err)
	}
	updateUser := service.userRepository.UpdateUser(userToUpdate)
	return updateUser
}

func (service *userService) All() []entity.User {
	return service.userRepository.AllUser()
}

func (service *userService) Profile(userID string) entity.User {
	return service.userRepository.ProfileUser(userID)
}
